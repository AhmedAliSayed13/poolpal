<?php
namespace App\Helpers;


use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Models\UserNotification;

class FirebaseNotification
{
    protected static function messaging()
    {
        $factory = (new Factory)->withServiceAccount(config('firebase.credentials.file'));
        return $factory->createMessaging();
    }

    public static function sendNotification($deviceToken, $title, $body, $request)
    {
        if (empty($deviceToken)) {
            Log::warning('FCM token is empty.');
            return false;
        }
        $data = self::prepareData($request);

        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        try {
            $response = self::messaging()->send($message);
            Log::info('FCM Notification Sent', ['response' => $response]);
            return $response;
        } catch (\Throwable $e) {
            Log::error('FCM Send Failed', ['error' => $e->getMessage()]);
            return false;
        }
    }

    public static function sendNotificationToMany($title, $body, $request)
    {
        $fcm_tokens_result = DB::table('Lubpo8Jc8_usermeta as um')
            ->join('Lubpo8Jc8_users as u', 'u.ID', '=', 'um.user_id')
            ->where('um.meta_key', 'fcm_token')
            ->whereNotNull('um.meta_value')
            ->where('um.meta_value', '!=', '')
            ->pluck('um.meta_value');

        $fcm_tokens = $fcm_tokens_result->toArray();

        if (empty($fcm_tokens)) {
            \Log::warning('FCM tokens list is empty.');
            return false;
        }
        $data    = self::prepareData($request);
        $message = CloudMessage::new ()
            ->withNotification(Notification::create($title, $body))
            ->withData($data);

        $messaging = self::messaging();

        $report = $messaging->sendMulticast($message, $fcm_tokens);

        self::createNotification($title, $body, $data);

        \Log::info('Multicast Notification Sent', [
            'successes' => $report->successes()->count(),
            'failures'  => $report->failures()->count(),
        ]);

        return $report;
    }

    public static function prepareData($request)
    {
        $data = [];
        if ($request->has('product_id')) {
            $data['product_id']   = $request->product_id;
            $data['click_action'] = 'FLUTTER_NOTIFICATION_CLICK';
        }

        if ($request->has('url')) {
            $data['url'] = $request->url;
        }
        return $data;
    }

    public static function createNotification($title, $body, $data)
    {
        $users = User::pluck('ID')->toArray();


        $notifications = [];

        foreach ($users as $userId) {
            $notifications[] = [
                'user_id'    => $userId,
                'title'      => $title,
                'body'       => $body,
                'data'       => json_encode($data),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

       UserNotification::insert($notifications);
    }

}
