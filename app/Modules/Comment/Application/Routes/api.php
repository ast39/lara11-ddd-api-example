<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Comment\Application\Controllers\CommentController;

Route::controller(CommentController::class)->group(function() {
    Route::get('/', 'index')->name('comments.index');
    Route::get('{id}', 'show')->name('comments.show');
    Route::post('/', 'store')->name('comments.store');
    Route::put('{id}', 'update')->name('comments.update');
    Route::delete('{id}', 'destroy')->name('v.destroy');
});
