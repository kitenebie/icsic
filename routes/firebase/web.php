<?php

use App\Models\FcmToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pushNotification;
use App\Services\FirebaseNotificationService;
use Illuminate\Support\Facades\Auth;

// Route::get('/test-push', [pushNotification::class, 'notify']);
Route::view('/test', "welcome1");
Route::post('/send-notification', [pushNotification::class, 'notify']);


Route::post('/save-token', function (Request $request) {
    $request->validate(['fcm_token' => 'required|string']);

    $userId = Auth::id();

    // Check if the user already has a token saved
    $existingToken = FcmToken::where('user_id', $userId)->first();

    if ($existingToken) {
        return response()->json(['message' => 'User token already exists'], 200);
    }

    // Save the new token if the user doesn't have one yet
    FcmToken::create([
        'user_id'   => $userId,
        'fcm_token' => $request->fcm_token,
    ]);

    return response()->json(['message' => 'Token saved'], 201);
});