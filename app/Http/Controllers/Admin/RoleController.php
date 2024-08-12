<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function show()
    {
        $admin = auth('admin')->id();

        $roles = Role::where('admin_id' , $admin)->get();

        return $this->response(RoleResource::collection($roles));
    }

    public function store(RoleRequest $request)
    {

        $result = (new RoleService())->store($request);

        return $this->response(
            $result->data,
            $result->message,
            $result->status
        );
    }

    public function showOne($id)
    {
        $role = Role::with('permissions')->find($id);

        return $this->response(new RoleResource($role));
    }


    public function update(RoleRequest $request,$id)
    {
        $result = (new RoleService())->update($id,$request);

        return $this->response(
            new RoleResource($result->data),
            $result->message,
            $result->status
        );
    }

    public function destroy($id)
    {
        $adminId = auth('admin')->id();

        Role::where('id' , $id)->where('admin_id' ,$adminId)
        ->delete();

        return $this->response(response(),'Role deleted successfully');
    }

    public function showPermission()
    {
        $permissions = Permission::all(['id' , 'name']);

        return $this->response($permissions,'permissions have been get successfully');

    }
}
