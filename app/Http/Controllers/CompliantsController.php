<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class CompliantsController extends Controller
{
    public function WriteComplaintAdmins(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $admin->compliants()->create([
            'content' => $request['content'],
        ]);
        if ($admin) {
            return $this->response($admin, "Thanks for participating in the improvement of the application", 200);
        }
        return $this->response([], "resend the compliant again please", 401);
    }
    public function WriteComplaintEmployees(Request $request)
    {
        $employee = Auth::guard('employee')->user();
        $employee->compliants()->create([
            'content' => $request['content'],
        ]);

        if ($employee) {
            return $this->response($employee, "Thanks for participating in the improvement of the application", 200);
        }
        return $this->response([], "resend the compliant again please", 401);
    }
}
