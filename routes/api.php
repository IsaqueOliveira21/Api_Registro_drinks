<?php

use App\Http\Controllers\DrinkController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('login', [UserController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('logout', [UserController::class, 'logout']);
        Route::prefix('user')->group(function () {
            Route::get('', [UserController::class, 'index']);
            Route::post('store', [UserController::class, 'store']);
        });
        Route::prefix('drinks')->controller(DrinkController::class)->group(function() {
            Route::get('', 'rankIndex');
            Route::get('{user}/today', 'userDrinksToday');
            Route::post('{user}/store', 'store');
        });
    });
});
