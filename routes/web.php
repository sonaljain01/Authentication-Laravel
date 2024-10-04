<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GalleryController;
Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login')->middleware('throttle:7,6');

    Route::get('register', [AuthController::class, 'register_view'])->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register')->middleware('throttle:7,6');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('home', [AuthController::class, 'home'])->name('home');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('profile', [AuthController::class, 'profileView'])->name('profile.view');
    Route::post('profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('gallery', [GalleryController::class, 'viewGallery'])->name('gallery.view');
    Route::post('gallery/upload', [GalleryController::class, 'uploadImages'])->name('gallery.upload');
    Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('gallery.delete');
});
