<?php

namespace App\Helpers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseNotification
{
    protected static function messaging()
    {
        $factory = (new Factory())->withServiceAccount(
            config('firebase.credentials.file') // ✅ التصحيح هنا
        );
        return $factory->createMessaging();
    }

    public static function sendNotification($deviceToken, $title, $body)
    {
        $message = CloudMessage::withTarget(
            'token',
            $deviceToken
        )->withNotification(Notification::create($title, $body));

        return self::messaging()->send($message);
    }
}
