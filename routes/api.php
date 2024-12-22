<?php

use App\Http\Controllers\Api\RetweetController;
use App\Http\Controllers\Api\QuoteTweetController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    // Idea routes
    Route::get('ideas', [IdeaController::class, 'index']);
    Route::post('ideas', [IdeaController::class, 'store']);
    Route::get('ideas/{idea}', [IdeaController::class, 'show']);
    Route::put('ideas/{idea}', [IdeaController::class, 'update']);
    Route::delete('ideas/{idea}', [IdeaController::class, 'destroy']);
    // Comment routes
    Route::post('ideas/{idea}/comments', [CommentController::class, 'store']);
    Route::delete('comments/{comment}', [CommentController::class, 'destroy']);
     // Follow routes
    Route::post('users/{user}/follow', [FollowController::class, 'follow']);
    Route::delete('users/{user}/unfollow', [FollowController::class, 'unfollow']);
     // Retweet routes
    Route::post('ideas/{idea}/retweet', [RetweetController::class, 'retweet']);
    Route::delete('ideas/{idea}/unretweet', [RetweetController::class, 'unretweet']);
     // Quote tweet routes
    Route::post('ideas/{idea}/quote', [QuoteTweetController::class, 'store']);
     // Notification routes
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::put('notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
     // Media routes
    Route::post('media/upload', [MediaController::class, 'upload']);
    Route::delete('media/{filename}', [MediaController::class, 'destroy']);
}); // Fixed closing bracket syntax