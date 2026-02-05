<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ApiController;

Auth::routes(['register' => false]);
Route::get('/framed', function () {
            return view('framed');
        })->middleware('auth');

Route::middleware(['auth'])->group(function () {
        Route::get('/manage', [App\Http\Controllers\HomeController::class, 'dashboard']);
        
        
        Route::resource('users', UserController::class);
        Route::resource('notas', NotaController::class);
        Route::resource('stats', StatController::class);
        Route::resource('forum', ForumController::class);

        Route::get('/', [HomeController::class,'index'])->name('home');
        Route::get('/getbycity', [ApiController::class,'getbycity'])->name('getbycity');
        Route::get('/getcities', [ApiController::class,'getcities'])->name('getcities');

        Route::post('/upload-image', [ImageController::class, 'store'])->name('image.store');
});