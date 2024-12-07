<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Sso\Application\Controllers\UserController;

Route::controller(UserController::class)->group(function() {
    Route::get('/', 'index')->name('users.index');
    Route::get('{id}', 'show')->name('users.show');
    Route::post('/', 'store')->name('users.store');
    Route::put('{id}', 'update')->name('users.update');
    Route::delete('{id}', 'destroy')->name('users.destroy');
});
