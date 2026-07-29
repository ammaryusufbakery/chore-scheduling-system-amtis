<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class FirebaseService
{
    public static function sendPush($token, $title, $body, $data = [])
    {
        $projectId = env('FIREBASE_PROJECT_ID');
        $credentialsPath = base_path(env('FIREBASE_CREDENTIALS'));

        // Fetch OAuth2 Token dynamically from your service account JSON file
        $credentials = new ServiceAccountCredentials(
            'https://www.googleapis.com/auth/cloud-platform',
            $credentialsPath
        );

        $tokenArray = $credentials->fetchAuthToken();
        $accessToken = $tokenArray['access_token'];

        // Build FCM V1 JSON structure
        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $data // Optional custom custom key-value payloads
            ]
        ];

        // Send HTTP Request
        $response = Http::withToken($accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $payload);

        return $response->json();
    }
}