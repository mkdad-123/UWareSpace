<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Traits\NotificationTrait;

class EmployeeNotificationController extends Controller
{
    use NotificationTrait;

    public function __construct()
    {
        $this->setModel(new Employee() , auth()->guard('employee')->id());
    }
}
