<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

/***********************************/
//how to use
//this->notificationService->create( "Fdfs","Fsdfsdfs","867fc910ca282a534d895d"/device token here );
/***********************************/

class NotificationService
{
    private $pushyApiKey;

    public function __construct()
    {
        // Load the Pushy API key from the environment variables
        $this->pushyApiKey = env('PUSHY_SECRET_API_KEY');
    }

    public function create(string $title, string $content, string $deviceToken): void
    {
        // Prepare the payload for the notification
        $data = [
            'title' => $title,
            'body' => $content,
        ];

        // Prepare the options for the notification
        $options = [
            'notification' => [
                'badge' => 1,
                'sound' => 'ping.aiff',
                'title' => $title,
                'body' => $content,
                'interruption_level' => 'active',
            ],
        ];
        
        // Send the push notification via Pushy
        $this->sendPushNotification($data, $deviceToken, $options);
    }

    private function sendPushNotification(array $data, string $to, array $options): void
    {
        // Prepare the request payload
        $payload = [
            'data' => $data,
            'to' => $to,
            'options' => $options,
        ];

        // Send the request to Pushy
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://api.pushy.me/push?api_key=' . $this->pushyApiKey, $payload);

            if ($response->successful()) {
                Log::info('Push notification sent successfully!', [
                    'response' => $response->json(),
                ]);
            } else {
                Log::error('Failed to send push notification', [
                    'status' => $response->status(),
                    'response' => $response->json(),
                ]);
            }
        } catch (Exception $e) {
            Log::error('Error sending push notification', [
                'message' => $e->getMessage(),
            ]);
        }
    }

}
