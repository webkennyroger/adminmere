<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/auth/google', [\App\Http\Controllers\Api\AuthController::class, 'googleLogin']);
Route::post('/forgot-password', [\App\Http\Controllers\Api\PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [\App\Http\Controllers\Api\PasswordResetController::class, 'reset']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Mobile App Subscription Routes
    Route::get('/plans', [\App\Http\Controllers\Api\SubscriptionController::class, 'index']);
    Route::get('/subscription/status', [\App\Http\Controllers\Api\SubscriptionController::class, 'status']);
    Route::post('/subscribe', [\App\Http\Controllers\Api\SubscriptionController::class, 'subscribe']);

    // Activities Sync
    Route::post('/activities', [\App\Http\Controllers\Api\ActivityController::class, 'store']);
    Route::get('/activities', [\App\Http\Controllers\Api\ActivityController::class, 'index']);
});
