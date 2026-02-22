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
        $user = $request->user();
        $user->load('profile');
        $data = $user->toArray();
        // Append additional fields expected by mobile app
        $data['image_url'] = $user->image_url;
        $data['cover_url'] = $user->cover_url;
        $data['surname'] = $user->profile->last_name ?? '';
        $data['bio'] = $user->profile->bio ?? '';
        $data['city'] = $user->profile->city ?? '';
        $data['phone'] = $user->profile->phone ?? '';
        $data['gender'] = $user->profile->gender ?? '';
        $data['birthDate'] = $user->profile->birth_date ?? '';
        $data['height'] = $user->profile->height ?? '';
        $data['weight'] = $user->profile->weight ?? '';
        $data['settings'] = $user->profile->settings ?? [];
        return $data;
    });

    // Mobile App Subscription Routes
    Route::get('/plans', [\App\Http\Controllers\Api\SubscriptionController::class, 'index']);
    Route::get('/subscription/status', [\App\Http\Controllers\Api\SubscriptionController::class, 'status']);
    Route::post('/subscribe', [\App\Http\Controllers\Api\SubscriptionController::class, 'subscribe']);

    // Stories API
    Route::get('/stories', [\App\Http\Controllers\Api\StoryController::class, 'index']);
    Route::post('/stories', [\App\Http\Controllers\Api\StoryController::class, 'store']);

    // Polls API
    Route::post('/polls', [\App\Http\Controllers\Api\PollController::class, 'store']);
    Route::delete('/polls/{id}', [\App\Http\Controllers\Api\PollController::class, 'destroy']);
    Route::post('/polls/{id}/vote', [\App\Http\Controllers\Api\PollController::class, 'vote']);
    Route::post('/polls/{id}/like', [\App\Http\Controllers\Api\LikeController::class, 'toggleItemLike']);

    // Posts API
    Route::post('/posts', [\App\Http\Controllers\Api\PostController::class, 'store']);
    Route::delete('/posts/{id}', [\App\Http\Controllers\Api\PostController::class, 'destroy']);
    Route::post('/posts/{id}/like', [\App\Http\Controllers\Api\LikeController::class, 'toggleItemLike']);

    // Activities API
    Route::get('/activities', [\App\Http\Controllers\Api\ActivityController::class, 'index']);
    Route::post('/activities', [\App\Http\Controllers\Api\ActivityController::class, 'store']);
    Route::post('/activities/sync', [\App\Http\Controllers\Api\ActivityController::class, 'sync']);
    Route::post('/activities/upload', [\App\Http\Controllers\Api\ActivityController::class, 'upload']);
    Route::get('/activities/history', [\App\Http\Controllers\Api\ActivityController::class, 'history']);
    Route::get('/activities/{id}', [\App\Http\Controllers\Api\ActivityController::class, 'show']);
    Route::put('/activities/{id}', [\App\Http\Controllers\Api\ActivityController::class, 'update']);
    Route::delete('/activities/{id}', [\App\Http\Controllers\Api\ActivityController::class, 'destroy']);
    Route::post('/activities/{id}/like', [\App\Http\Controllers\Api\LikeController::class, 'toggleItemLike']);
    Route::post('/activities/{id}/vote', [\App\Http\Controllers\Api\ActivityController::class, 'vote']);
    Route::post('/activities/{id}/comment', [\App\Http\Controllers\Api\CommentController::class, 'store']);
    Route::post('/comments/{id}/like', [\App\Http\Controllers\Api\LikeController::class, 'toggleCommentLike']);
    Route::delete('/comments/{id}', [\App\Http\Controllers\Api\CommentController::class, 'destroy']);

    // User/Social API
    Route::get('/users/suggested', [\App\Http\Controllers\Api\UserController::class, 'suggested']);
    Route::post('/users/{id}/follow', [\App\Http\Controllers\Api\UserController::class, 'toggleFollow']);
    Route::get('/users/following', [\App\Http\Controllers\Api\UserController::class, 'following']);
    Route::get('/users/{id}', [\App\Http\Controllers\Api\UserController::class, 'profile']);
    Route::post('/user/profile', [\App\Http\Controllers\Api\UserController::class, 'updateProfile']);

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
