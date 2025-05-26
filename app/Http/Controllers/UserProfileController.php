<?php

namespace App\Http\Controllers;

use App\Exports\PostsTemplateExport;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserprofileRequest;
use App\Http\Requests\UploadPhotoRequest;
use App\Imports\PostsImport;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class UserProfileController extends Controller
{
    public function profile($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $posts = Post::publishedMainPostsByUser($user->id)->get();
        return view('userprofile/user-profile', compact('user', 'posts'));
    }

    public function edit(User $user)
    {

        return view('userprofile/edit', compact('user'));
    }
    public function uploadPhoto(UploadPhotoRequest $request)
    {
        $user = auth()->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request->file('file')->store('profile-photos', 'public');
        $user->profile_photo = $path;
        $user->save();

        return response()->json(['path' => Storage::url($path)]);
    }

    public function update(UpdateUserprofileRequest $request, User $user)
    {
        $user->update($request->validated());
        $user->save();

        return to_route('profile', $user->username)
            ->with('status', 'Post updated successfully');
    }

    public function importPosts(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,xls',
        ]);

        $import = new PostsImport();

        try {
            Excel::import($import, $request->file('file'));

            if ($import->failures()->isNotEmpty()) {
                $errores = [];

                foreach ($import->failures() as $failure) {
                    $errores[] = __('Row :row: :errors', [
                        'row' => $failure->row(),
                        'errors' => implode(', ', $failure->errors()),
                    ]);
                }

                return back()
                    ->withErrors($errores)
                    ->with('warning', __('Some rows contain validation errors.'));
            }

            return back()->with('success', __('Posts imported successfully!'));
        } catch (ValidationException $e) {
            Log::error('Error en la importación del Excel: ' . $e->getMessage());

            return back()
                ->withErrors(['file' => __('There was an error processing the Excel file. Check the format.')])
                ->with('error', __('Import error.'));
        } catch (\Exception $e) {
            Log::error('Error general en importación: ' . $e->getMessage());

            return back()
                ->withErrors(['file' => __('Something went wrong while processing the file.')])
                ->with('error', __('Unexpected error.'));
        }
    }


    public function downloadTemplate()
    {
        return Excel::download(new PostsTemplateExport, 'posts_template.xlsx');
    }
}

