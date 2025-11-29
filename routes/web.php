<?php

use App\Http\Controllers\ProfileController; // Existing
use App\Http\Controllers\PostController;    // Add this
use App\Http\Controllers\UserController;    // Add this
use App\Http\Controllers\SearchController;  // Add this
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Update Dashboard to show posts
Route::get('/dashboard', function () {
    $posts = Post::with('user')->latest()->get();
    return view('dashboard', compact('posts'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Existing Profile Routes (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post Routes
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::get('/post/edit/{post}', [PostController::class, 'edit'])->name('post.edit');
    Route::post('/post/edit/{post}', [PostController::class, 'update'])->name('post.update');
    Route::post('/post/delete/{post}', [PostController::class, 'destroy'])->name('post.destroy');

    // User/Follow Routes
    Route::post('/user/follow', [UserController::class, 'follow'])->name('user.follow');
    Route::post('/user/unfollow', [UserController::class, 'unfollow'])->name('user.unfollow');
});

// Public Routes
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');

require __DIR__.'/auth.php';