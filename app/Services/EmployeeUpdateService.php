<?php

namespace App\Services;

use App\Models\Employee;
use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeeUpdateService{

    public OperationResult $result;

    protected function checkPassword($data)
    {
        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }else{
            $data = Arr::except($data,array('password'));
        }
        return $data;
    }

    protected function checkEmail($data)
    {
        if(empty($data['email'])) {
            $data = Arr::except($data, array('email'));
        }
        return $data;
    }

    protected function updateUser($id,$data)
    {
        $user = Employee::find($id);

         $user->update($data);

         return $user;
    }

    protected function getRole($roleId)
    {
        return Role::whereId($roleId)->first();
    }

    protected function setRoleInUser($user , $role)
    {
        $user->assignRole($role);
    }

    protected function deleteRole($id)
    {
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    }

    public function update($request , $id)
    {
        try {

            DB::beginTransaction();

            $data = $this->checkPassword($request->except('role_id'));

            $data = $this->checkEmail($data);

            $user = $this->updateUser($id ,$data);

            $role = $this->getRole($request->role_id);

            $this->deleteRole($id);

            $this->setRoleInUser($user,$role);

            $employee = Employee::with('roles')->find($id);

            DB::commit();

            $this->result = new OperationResult('Employee has been updated successfully',$employee);

        } catch (Exception $e){

            DB::rollBack();

            return $this->result = new OperationResult($e->getMessage() , response(),500);
        }
        return $this->result;
    }
}
