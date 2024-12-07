<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Post\Application\Controllers\PostController;

Route::controller(PostController::class)->group(function() {
    Route::get('/', 'index')->name('posts.index');
    Route::get('{id}', 'show')->name('posts.show');
    Route::post('/', 'store')->name('posts.store');
    Route::put('{id}', 'update')->name('posts.update');
    Route::delete('{id}', 'destroy')->name('posts.destroy');
});
