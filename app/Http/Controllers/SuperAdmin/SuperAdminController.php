<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Compliant;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{

    // عرض كل الأدمنز الموجودين
    public function ShowAdmins()
    {
        $admins = Admin::get();
        if ($admins) {
            return $this->response($admins, "show admins success", 200);
        } else {
            return $this->response([], "there no admins yet", 401);
        }}
        // عرض الأدمنز الفعالين
        public function ShowAdminsActive()
        {
            $admins = Admin::where('active','1')->get();
            if ($admins) {
                return $this->response($admins, "show admins success", 200);
            } else {
                return $this->response([], "there no admins yet", 401);
            }
        }
        // عرض الأدمنز الغير فعالين
        public function ShowAdminsUnActive()
        {
            $admins = Admin::where('active','0')->get();
            if ($admins) {
                return $this->response($admins, "show admins success", 200);
            } else {
                return $this->response([], "there no admins yet", 401);
            }
        }
        // تعطيل حساب فعال للأدمن
        public function ToggleAdminsStatus(Request $request)
        {
            if (!Admin::whereEmail($request->email)->first()) {
                return $this->response([], "this admin is not found or the email is not exist", 401);
            }
            $admin = Admin::whereEmail($request->email)->first();
            if ($admin->active == 1) {
                $admin->active = 0;
                $admin->save();
                return $this->response($admin, "this admin is pinding now", 200);
            } else if ($admin->active == 0) {
                return $this->response($admin, "this admin is already pinded", 200);
            }
        }
        // إعادة تفعيل حساب للأدمن غير فعال مسبقا
        public function makeAdminsStatusActive(Request $request)
        {
            if (!Admin::whereEmail($request->email)->first()) {
                return $this->response([], "this admin is not found or the email is not exist", 401);
            }
            $admin = Admin::whereEmail($request->email)->first();
            if ($admin->active == 0) {
                $admin->active = 1;
                $admin->save();
                return $this->response($admin, "this admin is active  now", 200);
            } else if ($admin->active == 1) {
                return $this->response($admin, "this admin is already active", 200);
            }
        }
        //عرض شكاوى الأدمنز
        public function ShowCompliants()
        {
            $compliants = Compliant::where('compliantable_type', 'Employee')->get();
            if ($compliants != null){
            return $this->response($compliants, "this all compliants", 200);
            }
            if ($compliants == null) {
                return $this->response([], "there are no compliants", 401);
            }
        }
}
