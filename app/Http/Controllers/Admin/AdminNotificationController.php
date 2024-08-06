<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\NotificationTrait;

class AdminNotificationController extends Controller
{
    use NotificationTrait;

    public function __construct()
    {
        $this->setModel(new Admin() , auth()->guard('admin')->id());
    }
}
