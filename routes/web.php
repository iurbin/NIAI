<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Auth::routes(['register' => false]);
Route::middleware(['auth'])->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');
        Route::resource('users', UserController::class);
        Route::get('/', function () {
            return view('welcome');
        });
});