<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Posts\PostController;
use App\Http\Controllers\UserProfileController;
use App\Livewire\Posts\PostForm;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/{post}/show',[PostController::class, 'show'])->name('post.show');

Route::get('/{username}',[UserProfileController::class, 'profile'])->name('profile');
Route::get('/user/{id}/posts/pdf', [PDFController::class, 'generateUserPostsPDF'])->name('user.posts.pdf');

Route::middleware(['auth', 'admin'])->get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');

Route::middleware('auth')->group(function () {
    Route::get('/{user}/edit', [UserProfileController::class, 'edit'])->name('userprofile.edit');
    Route::patch('/{user}/update', [UserProfileController::class, 'update'])->name('userprofile.update');
    Route::post('/profile/upload-photo', [UserProfileController::class, 'uploadPhoto'])->name('profile.upload-photo');
    Route::post('/import-posts', [UserProfileController::class, 'importPosts'])->name('posts.import');
    Route::get('/posts/template/download', [UserProfileController::class, 'downloadTemplate'])->name('posts.template.download');

    Route::post('/post.store',[PostController::class, 'store'])->name('post.store');
    Route::post('/{post}/show.store',[PostController::class, 'storeResponse'])->name('post.show.store');
    Route::post('/{post}/like', [PostController::class, 'like'])->name('post.like');
    Route::delete('/{post}/destroy', [PostController::class, 'destroy'])->name('post.destroy');

    Route::get('/{user}/notifications]', [NotificationController::class, 'index'])->name('notifications.index');

    Route::get('/pdf/analisis-general', [PdfController::class, 'generatePageAnalysisPDF'])->name('pdf.analisis-general');

});









