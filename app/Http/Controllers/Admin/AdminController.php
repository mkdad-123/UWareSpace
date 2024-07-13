<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Compliant;
use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function ShowCompliants()
    {
        $compliants = Compliant::where('compliantable_type', 'Employee')->get();
        if($compliants != null){
        return $this->response($compliants, "this all compliants", 200);
        }
        if ($compliants == null) {
            return $this->response([], "there are no compliants", 401);
        }
    }
}
