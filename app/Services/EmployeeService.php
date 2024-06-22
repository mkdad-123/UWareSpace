<?php

namespace App\Services;

use App\Mail\SendJobEmail;
use App\Models\Employee;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class EmployeeService{

    protected function storeEmployee($data)
    {
        $data['admin_id'] = auth('admin')->id();

        return Employee::create($data);
    }

    protected function getRole($roleId)
    {
        return Role::whereId($roleId)->first();
    }

    protected function setRoleInUser($user , $role)
    {
        $user->assignRole($role);
    }

    protected function sendEmail($user,$role,$password)
    {
        Mail::to($user->email)->send(new SendJobEmail($user->name,$user->role,$password));
    }

    public function store($request)
    {
        try {

             DB::beginTransaction();

             $user = $this->storeEmployee($request->except('role_id'));

             $role = $this->getRole($request->role_id);

             $this->setRoleInUser($user,$role);

             $this->sendEmail($user,$role->name,$request->password);

             DB::commit();

        } catch (Exception $e){

            DB::rollBack();

            return response($e->getMessage());
        }
        return true;
    }

}
