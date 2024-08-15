<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\TestController;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->withoutMiddleware('auth.api');
    Route::post('/login', 'login')->withoutMiddleware(['auth.api']);
    Route::post('/logout', 'logout');
    Route::post('/refresh', 'refresh');
    Route::post('/me', 'me');
});

Route::get('/test', [TestController::class, 'index'])->withoutMiddleware('auth.api');

// instead of returning 404, it will return unauthorize
Route::any('{any}', [TestController::class, 'index']);
