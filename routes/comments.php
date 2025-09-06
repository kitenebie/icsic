<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Comment Routes
|--------------------------------------------------------------------------
|
| Routes for handling comment operations
|
*/

Route::middleware(['auth'])->group(function () {
    // Save comment
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    
    // Save main comment
    Route::post('/comments/main', [CommentController::class, 'storeMainComment'])->name('comments.main');
    
    // Save reply comment
    Route::post('/comments/reply', [CommentController::class, 'storeReply'])->name('comments.reply');
    
    // Get comments for a post
    Route::get('/comments/{postId}', [CommentController::class, 'getComments'])->name('comments.get');
});