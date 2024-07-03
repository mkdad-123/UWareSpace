<?php

namespace App\Services;

use App\Mail\SendJobEmail;
use App\Models\Employee;
use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class EmployeeStoreService{

    public OperationResult $result;

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
        $admin = auth('admin')->user();

        Mail::to($user->email)->send(new SendJobEmail($user->name,$role,$password,$admin));
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

            $this->result = new OperationResult('Employee has been created successfully',response());

        } catch (Exception $e){

            DB::rollBack();

            return $this->result = new OperationResult($e->getMessage() , response(),500);
        }

        return $this->result;
    }

}
