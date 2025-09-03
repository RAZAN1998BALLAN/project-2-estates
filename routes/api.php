<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommnentController;
use App\Http\Controllers\EstateController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ActiveUserMiddleware;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware(['auth:sanctum', ActiveUserMiddleware::class])->group(function () {
    Route::get('estate/favorite', [EstateController::class, 'myFavorite']);
    Route::apiResource('estate', EstateController::class);
    Route::post('estate/rate/{estate}', [EstateController::class, 'rate']);
    Route::post('estate/favorite/{estate}', [EstateController::class, 'favorite']);
    
    Route::patch('estate/{estate}/change', [EstateController::class, 'changeState']);
    Route::put('profile', [UserController::class, 'updateProfile']);
    Route::get('profile', [UserController::class, 'getProfile']);

    Route::get('my-services', [ServiceController::class, 'myServices']);
    Route::apiResource('user', UserController::class)->only(['index', 'show']);

    Route::apiResource('service', ServiceController::class)->only(['index', 'show']);

    Route::apiResource('comment', CommnentController::class)->except('update');

    Route::post('payment',[TransactionController::class,'pay']);


    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/statistics',[StatisticsController::class,'getStatistics']);
        Route::put('user/{user}/disable', [UserController::class, 'disableUser']);
        Route::put('user/{user}/enable', [UserController::class, 'enableUser']);
        Route::apiResource('service', ServiceController::class)->except(['index','show']);
    });
});
