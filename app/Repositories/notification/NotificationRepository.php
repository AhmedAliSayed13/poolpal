<?php namespace App\Repositories\notification;





use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\UserNotification;

class NotificationRepository implements NotificationInterface
{

    public function index($request)
    {

        $notifications = UserNotification::where('user_id', $request->get('user')->id)->orderBy('created_at', 'desc')->get();
        return $notifications;
    }

    public function show($request,$id)
    {

        $UserNotification = UserNotification::where([
            'user_id' => $request->get('user')->id,
            'id' => $id
        ])->first();

        if(!$UserNotification){
            return false;
        }

        $UserNotification->view = true;
        $UserNotification->save();


        return $UserNotification->refresh();
    }



}
