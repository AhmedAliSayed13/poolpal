<?php

namespace App\Repositories\notification;

use App\Models\UserNotification;
interface NotificationInterface
{
    public function index($request);
    public function show($request, $id);

}
