<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\NotaController;

Auth::routes(['register' => false]);
Route::middleware(['auth'])->group(function () {
        Route::get('/manage', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        
        Route::resource('users', UserController::class);
        Route::resource('notas', NotaController::class);

        Route::get('/', function () {
            return view('welcome');
        });
});