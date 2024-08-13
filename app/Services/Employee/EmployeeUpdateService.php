<?php

namespace App\Services\Employee;

use App\Models\Employee;
use App\ResponseManger\OperationResult;
use App\Services\PhoneService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class EmployeeUpdateService{

    protected OperationResult $result;

    protected $phoneService;

    public function __construct(PhoneService $phoneService)
    {
        $this->phoneService = $phoneService;
    }

    protected function updatePassword($data)
    {
        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }else{
            $data = Arr::except($data,array('password'));
        }
        return $data;
    }

    protected function updateEmail($data)
    {
        if(empty($data['email'])) {
            $data = Arr::except($data, array('email'));
        }
        return $data;
    }

    protected function updateUser($data , $user)
    {
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

    public function update($request , $user)
    {
        try {

            DB::beginTransaction();

            $adminId = auth('admin')->id();

            $data = $this->updatePassword($request->except(['role_id' , 'phones']));

            $data = $this->updateEmail($data);

            $user = $this->updateUser($data , $user);

            if($request->has('phones')){

                $this->phoneService->updatePhones($request->input('phones'),$user);
            }

            $role = $this->getRole($request->role_id);

            $this->deleteRole($user->id);

            $this->setRoleInUser($user,$role->name , $adminId);

           // $employee = Employee::with(['roles','phones'])->find($id);

            DB::commit();

            $this->result = new OperationResult('Employee has been updated successfully',$user);

        } catch (QueryException $e) {

            DB::rollBack();

            return $this->result = new OperationResult('Database error: ' . $e->getMessage(), response(), 500);

        } catch (Exception $e) {

            DB::rollBack();

            return $this->result = new OperationResult('An error occurred: ' . $e->getMessage(), response(), 500);
        }
        return $this->result;
    }
}
