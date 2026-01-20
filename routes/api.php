<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/auth/google', [\App\Http\Controllers\Api\AuthController::class, 'googleLogin']);
Route::post('/forgot-password', [\App\Http\Controllers\Api\PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [\App\Http\Controllers\Api\PasswordResetController::class, 'reset']);

// App Version Check
Route::get('/app-version', function () {
    return response()->json([
        'version' => '1.0.0', // Versão atual no servidor
        'build' => 1,
        'url' => 'https://mere-app.com.br/download', // Onde baixar a nova versão
        'message' => 'Uma nova versão do MERE está disponível!'
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Mobile App Subscription Routes
    Route::get('/plans', [\App\Http\Controllers\Api\SubscriptionController::class, 'index']);
    Route::get('/subscription/status', [\App\Http\Controllers\Api\SubscriptionController::class, 'status']);
    Route::post('/subscribe', [\App\Http\Controllers\Api\SubscriptionController::class, 'subscribe']);

    // Activities API
    Route::get('/activities', [\App\Http\Controllers\Api\ActivityController::class, 'index']);
    Route::post('/activities', [\App\Http\Controllers\Api\ActivityController::class, 'store']);
    Route::get('/activities/{id}', [\App\Http\Controllers\Api\ActivityController::class, 'show']);
    Route::put('/activities/{id}', [\App\Http\Controllers\Api\ActivityController::class, 'update']);
    Route::delete('/activities/{id}', [\App\Http\Controllers\Api\ActivityController::class, 'destroy']);
    Route::post('/activities/{id}/like', [\App\Http\Controllers\Api\ActivityController::class, 'toggleLike']);
    Route::post('/activities/{id}/comment', [\App\Http\Controllers\Api\ActivityController::class, 'comment']);
    Route::post('/activities/sync', [\App\Http\Controllers\Api\ActivityController::class, 'sync']);
    Route::post('/activities/upload', [\App\Http\Controllers\Api\ActivityController::class, 'upload']);

    // User/Social API
    Route::get('/users/suggested', [\App\Http\Controllers\Api\UserController::class, 'suggested']);
    Route::post('/users/{id}/follow', [\App\Http\Controllers\Api\UserController::class, 'toggleFollow']);
    Route::get('/users/following', [\App\Http\Controllers\Api\UserController::class, 'following']);
    Route::get('/users/{id}', [\App\Http\Controllers\Api\UserController::class, 'profile']);

    // Chat/Messages API
    Route::get('/messages/{userId}', [\App\Http\Controllers\Api\MessageController::class, 'getMessages']);
    Route::post('/messages', [\App\Http\Controllers\Api\MessageController::class, 'sendMessage']);
    Route::post('/messages/{userId}/read', [\App\Http\Controllers\Api\MessageController::class, 'markAsRead']);
    Route::get('/conversations', [\App\Http\Controllers\Api\MessageController::class, 'getConversations']);
    
    // Stats & Dashboard API
    Route::get('/stats/dashboard', [\App\Http\Controllers\Api\StatsController::class, 'dashboard']);
    Route::get('/stats/challenges/active', [\App\Http\Controllers\Api\StatsController::class, 'activeChallenges']);
    Route::get('/stats/challenges/available', [\App\Http\Controllers\Api\StatsController::class, 'availableChallenges']);
    Route::get('/stats/tier', [\App\Http\Controllers\Api\StatsController::class, 'userTier']);
});
