<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;


Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'user'], function () {
        require base_path('app/Modules/Sso/Application/Routes/api.php');
    });
});


Route::fallback(function () {
    return response()->json([
        'message' => 'Endpoint not exist. If error persists, contact alexandr.statut@gmail.com',
    ], 404);
});

if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}
