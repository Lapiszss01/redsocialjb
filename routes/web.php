<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Posts\PostController;
use App\Http\Controllers\Posts\UserProfileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/{username}',[UserProfileController::class, 'profile'])->name('profile');
Route::get('/{post}/show',[PostController::class, 'show'])->name('post.show');
Route::get('/user/{id}/posts/pdf', [PDFController::class, 'generateUserPostsPDF'])->name('user.posts.pdf');

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/{user}/edit', [UserProfileController::class, 'edit'])->name('userprofile.edit');
    Route::patch('/{user}/update', [UserProfileController::class, 'update'])->name('userprofile.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/post.store',[PostController::class, 'store'])->name('post.store');
    Route::post('/{post}/show.store',[PostController::class, 'storeResponse'])->name('post.show.store');
    Route::post('/{post}/like', [PostController::class, 'like'])->name('post.like');
    Route::delete('/{post}/destroy', [PostController::class, 'destroy'])->name('post.destroy');
    Route::post('/posts/upload', [PostController::class, 'upload'])->name('posts.upload');


});

Route::middleware(['auth', 'admin'])->get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
Route::get('/pdf/analisis-general', [PdfController::class, 'generatePageAnalysisPDF'])->name('pdf.analisis-general');






