<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseNotificationService;

class pushNotification extends Controller
{
    public function notify(Request $request, FirebaseNotificationService $fcm)
    {
        // $request->validate([
        //     'fcm_token' => 'required|string',
        // ]);

        // $title = 'Hello!';
        // $body = 'This is a push notification from Laravel.';

        // $result = $fcm->sendNotification($request->fcm_token, $title, $body);
        // return $fcm->sendNotificationToAll('Broadcast', 'This is sent to all users.');

        // return response()->json($result);
    }
}
