<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService{

    protected function storeRole($name)
    {
        return Role::create([
            'name' => $name,
            'guard_name' => 'employee'
        ]);
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
        $role = Role::find($id);
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

        } catch (Exception $e){

            DB::rollBack();

            return response($e->getMessage());
        }
        return true;
    }

    public function update($id , $request)
    {

        try {

            DB::beginTransaction();

            $role = $this->updateRole($id,$request->name);

            $permissions = $this->getPermissions($request->permission);

            $this->storePermission($permissions,$role);

            DB::commit();

            $role = Role::with('permissions')->whereId($id)->get();

        } catch (Exception $e){

            DB::rollBack();

            return response($e->getMessage());
        }
        return $role;
    }

}
