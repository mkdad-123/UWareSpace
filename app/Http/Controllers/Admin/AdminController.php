<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Compliant;
use App\Models\Employee;
use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function ShowCompliants()
    {
        $admin = auth('admin')->user()->id;
        $emps = Employee::where('admin_id' ,$admin)->pluck('id');
        $compliants = [];
        foreach ($emps as $e){
        $compliant = Compliant::where("compliantable_type", "Employee")->where('compliantable_id', $e)->get();
        array_push($compliants, $compliant);
        }
        if($compliants != null){
        return $this->response($compliants, "this all compliants", 200);
        }
        if ($compliants == null) {
            return $this->response([], "there are no compliants", 401);
        }
    }
}

