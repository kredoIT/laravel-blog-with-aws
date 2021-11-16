<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    
    Route::get('/', [PostController::class, 'index'])->name('index');
    
    Route::group(['prefix' => 'post', 'as' => 'post.'], function(){

        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/store', [PostController::class, 'store'])->name('store');

        Route::get('/{id}/show', [PostController::class, 'show'])->name('show');

        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
        Route::patch('/{id}/update', [PostController::class, 'update'])->name('update');

        Route::delete('/{id}/destroy', [PostController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], function(){

        Route::get('/profile/show', [UserController::class, 'show'])->name('show');
        Route::get('/profile/edit', [UserController::class, 'edit'])->name('edit');
        Route::patch('/profile/update', [UserController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'comment', 'as' => 'comment.'], function(){

        Route::post('/comment/{id}/store', [CommentController::class, 'store'])->name('store');
        Route::delete('/comment/{id}/destroy', [CommentController::class, 'destroy'])->name('destroy');
    });

});