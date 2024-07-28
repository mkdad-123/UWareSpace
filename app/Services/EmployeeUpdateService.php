<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Phone;
use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class EmployeeUpdateService
{

    public OperationResult $result;

    protected function validEmail($data, $id)
    {
        $user = Employee::find($id);

        $data->validate([
            'email' => 'sometimes|email|', Rule::unique('employees')->ignore($user->id),
        ]);

        return $user;
    }

    protected function updatePassword($data)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data = Arr::except($data, array('password'));
        }
        return $data;
    }

    protected function updateEmail($data)
    {
        if (empty($data['email'])) {
            $data = Arr::except($data, array('email'));
        }
        return $data;
    }

    protected function updateUser($id, $data, $user)
    {
        $user->update($data);

        return $user;
    }

    protected function getRole($roleId)
    {
        return Role::whereId($roleId)->first();
    }

    protected function setRoleInUser($user, $role)
    {
        $user->assignRole($role);
    }

    protected function deleteRole($id)
    {
        DB::table('model_has_roles')->where('model_id', $id)->delete();
    }

    public function update($request, $id)
    {
        try {

            DB::beginTransaction();

            $user = $this->validEmail($request, $id);

            $data = $this->updatePassword($request->except(['role_id', 'phones']));

            $data = $this->updateEmail($data);

            $user = $this->updateUser($id, $data, $user);

            if ($request->input('phones')) {
                (new PhoneService())->updatePhones($request->input('phones'), $user);
            }

            $role = $this->getRole($request->role_id);

            $this->deleteRole($id);

            $this->setRoleInUser($user, $role);

            $employee = Employee::with(['roles', 'phones'])->find($id);

            DB::commit();

            $this->result = new OperationResult('Employee has been updated successfully', $employee);
        } catch (Exception $e) {

            DB::rollBack();

            return $this->result = new OperationResult($e->getMessage(), response(), 500);
        }
        return $this->result;
    }
}
