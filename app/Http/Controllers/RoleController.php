<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function show()
    {
        $roles = Role::all();
        return $this->response($roles,'successfully');
    }

    public function showPermissions()
    {
        $permissions = Permission::all();
        return $this->response($permissions);
    }

    public function store(RoleRequest $request)
    {

        (new RoleService())->store($request);

        return $this->response(response());
    }

    public function showOne($id)
    {
        $role = Role::with('permissions')->find($id);

        return $this->response($role,'successfully');
    }


    public function update(RoleRequest $request, $id)
    {
        $role = (new RoleService())->update($id,$request);

        return $this->response($role);
    }

    public function destroy($id)
    {
        Role::find($id)->delete();

        return $this->response(response(),'Role deleted successfully');
    }
}
