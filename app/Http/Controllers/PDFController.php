<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Post;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generateUserPostsPDF($userId)
    {
        //dd($userId);
        $user = User::findOrFail($userId);
        $posts = Post::where('user_id', $userId)->get();
        //dd($posts);

        if ($posts->isEmpty()) {
            return back()->with('error', 'Este usuario no tiene posts.');
        }

        $pdf = PDF::loadView('pdf.pdf-user-posts', compact('user', 'posts'));

        return $pdf->download('posts_usuario_'.$user->id.'.pdf');
    }
}
