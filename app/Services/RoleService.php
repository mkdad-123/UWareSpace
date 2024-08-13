<?php

namespace App\Services;

use App\ResponseManger\OperationResult;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService{

    public OperationResult $result;

    protected function storeRole($name)
    {
        $adminId = auth('admin')->id();

        $role =  Role::create([
            'name' => $name,
            'guard_name' => 'employee',
        ]);

        $role->admins()->attach($adminId);

        return $role;
    }

    protected function getPermissions($permissionIds)
    {
         return Permission::whereIn('id',$permissionIds)->get();
    }

    protected function storePermission($permissions,Role $role)
    {
        $role->syncPermissions($permissions);
    }

    protected function updateRole($id,$name)
    {
        $adminId = auth('admin')->id();
        $role = Role::where('id' , $id)->where('admin_id' ,$adminId)->first();
        $role->name = $name;
        $role->save();

        return $role;
    }


    public function store($request)
    {

        try {

            DB::beginTransaction();

            $role = $this->storeRole($request->name);

            $permissions = $this->getPermissions($request->permission);

            $this->storePermission($permissions,$role);

            DB::commit();

            $this->result = new OperationResult('Role has been created successfully', response());

        } catch (QueryException $e) {

            DB::rollBack();

            return $this->result = new OperationResult('Database error: ' . $e->getMessage(), response(), 500);

        } catch (Exception $e) {

            DB::rollBack();

            return $this->result = new OperationResult('An error occurred: ' . $e->getMessage(), response(), 500);
        }
        return $this->result;
    }

    public function update($id , $request)
    {

        try {

            DB::beginTransaction();

            $role = $this->updateRole($id,$request->name);

            $permissions = $this->getPermissions($request->permission);

            $this->storePermission($permissions,$role);

            $role = Role::with('permissions')->find($id);;

            $this->result = new OperationResult('Role has been updated successfully',$role);

            DB::commit();

        } catch (QueryException $e) {

            DB::rollBack();

            return $this->result = new OperationResult('Database error: ' . $e->getMessage(), response(), 500);

        }
        catch (Exception $e) {

            DB::rollBack();

            return $this->result = new OperationResult('An error occurred: ' . $e->getMessage(), response(), 500);
        }
        return $this->result;
    }

}
