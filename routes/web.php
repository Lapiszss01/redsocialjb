<?php

use App\Http\Controllers\Posts\PostController;
use App\Http\Controllers\Posts\UserProfileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

//Route::view('/', 'welcome')->name('home');;
Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/{username}',[UserProfileController::class, 'profile'])->name('profile');
Route::post('/{post}/like', [PostController::class, 'like'])->name('post.like');

Route::post('/post.store',[PostController::class, 'store'])->name('post.store');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




