<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\ForumController;

Auth::routes(['register' => false]);
Route::get('/framed', function () {
            return view('framed');
        })->middleware('auth');

Route::middleware(['auth'])->group(function () {
        Route::get('/manage', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        
        Route::resource('users', UserController::class);
        Route::resource('notas', NotaController::class);
        Route::resource('stats', StatController::class);
        Route::resource('forum', ForumController::class);

        Route::get('/', function () {
            return view('welcome');
        })->middleware('auth')->name('home');
        Route::post('/upload-image', [ImageController::class, 'store'])->name('image.store');
});