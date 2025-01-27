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
        public function ToggleAdminsStatus(Admin $admin)
        {
            $admin->active = !($admin->active);

            $admin->save();

            return $this->response($admin, "the active has been changed");
        }

        //عرض شكاوى الأدمنز
        public function ShowCompliants()
        {
            $compliants = Compliant::where('compliantable_type', 'Employee')->get();

            return $this->response($compliants, "this all compliants", 200);

        }
}
