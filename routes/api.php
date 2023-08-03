<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', [UserController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('logout', [UserController::class, 'logout']);
        Route::prefix('user')->group(function () {
            Route::post('store', [UserController::class, 'store']);
        });
    });
});
