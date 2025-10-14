<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FcmController extends Controller
{
    public function saveToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string'
        ]);

        $user = Auth::user();
        if ($user) {
            $user->update(['fcm_token' => $request->fcm_token]);
            return response()->json(['success' => true, 'message' => 'FCM token saved successfully']);
        }

        return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
    }
}
