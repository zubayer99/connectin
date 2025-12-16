<?php

use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/details', [ProfileController::class, 'editDetails'])->name('profile.edit_details');
    Route::patch('/profile/details', [ProfileController::class, 'updateDetails'])->name('profile.update_details');
    Route::get('/profile/{user?}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/network', [ConnectionController::class, 'index'])->name('network.index');
    Route::post('/connect', [ConnectionController::class, 'store'])->name('connection.store');
    Route::patch('/connections/{connection}', [ConnectionController::class, 'update'])->name('connection.update');
    Route::delete('/connections/{connection}', [ConnectionController::class, 'destroy'])->name('connection.destroy');
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::post('/posts/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');
    
    // Job Routes
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
});

require __DIR__.'/auth.php';
