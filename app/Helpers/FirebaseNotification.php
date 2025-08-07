<?php

namespace App\Helpers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Log;

class FirebaseNotification
{
    protected static function messaging()
    {
        $factory = (new Factory)->withServiceAccount(config('firebase.credentials.file'));
        return $factory->createMessaging();
    }

    public static function sendNotification($deviceToken, $title, $body)
    {
        if (empty($deviceToken)) {
            Log::warning('FCM token is empty.');
            return false;
        }

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification(Notification::create($title, $body));

        // try {
            $response = self::messaging()->send($message);
            Log::info('FCM Notification Sent', ['response' => $response]);
            return $response;
        // } catch (\Throwable $e) {
            // Log::error('FCM Send Failed', ['error' => $e->getMessage()]);
            // return false;
        // }
    }
}
