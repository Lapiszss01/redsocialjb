<?php

use App\Http\Controllers\Posts\PostController;
use App\Http\Controllers\Posts\UserProfileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', [PostController::class, 'index'])->name('home');

Route::get('/{username}',[UserProfileController::class, 'profile'])->name('profile');
Route::get('/{post}/show',[PostController::class, 'show'])->name('post.show');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/{post}/show.store',[PostController::class, 'storeResponse'])->name('post.show.store');
    Route::post('/{post}/like', [PostController::class, 'like'])->name('post.like');
    Route::post('/post.store',[PostController::class, 'store'])->name('post.store');
    Route::delete('/{post}/destroy', [PostController::class, 'destroy'])->name('post.destroy');
    Route::post('/posts/upload', [PostController::class, 'upload'])->name('posts.upload');


});




