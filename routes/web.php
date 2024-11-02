<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    HomeController,
    AlbumController,
    PhotoController,
    ProfileController,
};

// Redirect root URL to login
Route::redirect('/','/auth/login');

// // Authentication routes
Route::controller(AuthController::class)->group(function() {
    Route::get('auth/login', 'showLoginForm')->name('login')->middLeware('guest');
    Route::post('auth/login', 'postLogin')->name('postLogin');
    Route::post('logout', 'logout')->name('logout');
    Route::get('auth/register', 'showRegistrationForm')->name('register.form');
    Route::post('auth/register', 'register')->name('register');
});


Route::middleware('auth')->group(function () {
    // Home route
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Album resource routes
    Route::resource('albums', AlbumController::class);
    //photo routes
    Route::get('albums/{album}/photos',[PhotoController::class,'index'])
    ->name('albums.photos');
    Route::resource('photos', PhotoController::class);
    Route::post('photos/{photo}/like',[PhotoController::class,'like'])
    ->name('photos.like');
    Route::get('/photos/{photo}/comments',[PhotoController::class,'showComments'])
    ->name('photos.comments');
    Route::post('/photos/{photo}/comments',[PhotoController::class,'storeComment'])
    ->name('photos.comment.store');
    // profile store
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});    