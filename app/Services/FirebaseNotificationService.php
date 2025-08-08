<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Google_Client;

class FirebaseNotificationService
{
    protected $credentialsPath;

    public function __construct()
    {
        $this->credentialsPath = storage_path('app/firebase/firebase_credentials.json');
    }

    protected function getAccessToken()
    {
        return Cache::remember('firebase_access_token', 3500, function () {
            $client = new Google_Client();
            $client->setAuthConfig($this->credentialsPath);
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->fetchAccessTokenWithAssertion();

            return $client->getAccessToken()['access_token'];
        });
    }

    public function sendNotification($fcmToken, $title, $body)
    {
        $projectId = json_decode(file_get_contents($this->credentialsPath))->project_id;
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $message = [
            'message' => [
                'token' => $fcmToken,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'webpush' => [
                    'headers' => [
                        'Urgency' => 'high',
                    ],
                    'notification' => [
                        'icon' => '/icon.png',
                    ],
                ],
            ],
        ];

        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->post($url, $message);

        return $response->json();
    }

    public function sendNotificationToAll($ids, $title, $body, $url)
    {
        // Convert to array if it's a JSON string
        if (is_string($ids)) {
            $decoded = json_decode($ids, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $ids = $decoded;
            } else {
                $ids = explode(',', $ids);
            }
        }

        // Ensure all elements are trimmed and unique
        $ids = array_unique(array_map('trim', (array) $ids));

        // if (empty($ids)) {
        //     return false; // No user IDs provided
        // }

        // Get FCM tokens
        $tokens = \App\Models\FcmToken::whereIn('user_id', $ids)
            ->pluck('fcm_token')
            ->filter() // Remove nulls
            ->unique() // Avoid duplicates
            ->toArray();
        // dd($tokens);
        if (empty($tokens)) {
            $tokens = \App\Models\FcmToken::pluck('fcm_token')
                ->filter() // Remove nulls
                ->unique() // Avoid duplicates
                ->toArray();
        }

        // Prepare FCM request
        $accessToken = $this->getAccessToken();
        $projectId = json_decode(file_get_contents($this->credentialsPath))->project_id;
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        foreach ($tokens as $token) {
            $message = [
                'message' => [
                    'token' => $token,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'data' => [
                        'url' => 'https://yourdomain.com/target-page', // Change this to your actual redirect link
                    ],
                ],
            ];

            Http::withToken($accessToken)->post($url, $message);
        }

        return true;
    }
}
