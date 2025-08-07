<?php

namespace App\Http\Controllers\API\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\notification\NotificationInterface;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\notification\StoreNotificationRequest;
use App\Http\Requests\notification\UpdateNotificationRequest;
use App\Models\UserNotification;
class NotificationController extends BaseController
{
    protected $notificationInterface;

    public function __construct(NotificationInterface $notificationInterface)
    {
        $this->notificationInterface = $notificationInterface;
    }

    public function index(Request $request)
    {
        $data = $this->notificationInterface->index($request);
        return $this->success($data, 'Data retrieved successfully');
    }
    public function show(Request $request,$id)
    {
        // return $id;
        $data = $this->notificationInterface->show($request,$id);
        if(!$data){
            return $this->error('Data not found', [], 404);
        }
        return $this->success($data, 'Data retrieved successfully');
        // return true;
    }

}
