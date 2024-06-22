<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{

    public function show()
    {
        $employees = Employee::all();

        return $this->response($employees);
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();

        return $this->response($roles);
    }

    public function store(EmployeeStoreRequest $request)
    {
        (new EmployeeService())->store($request);

        return $this->response(response());
    }

    public function showOne($id)
    {
        Employee::with('roles')->whereId($id);

    }

    public function update(EmployeeUpdateRequest $request, $id)
    {

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $Employee = Employee::find($id);
        $Employee->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $Employee->assignRole($request->input('roles'));
        $Employee = Employee::with('roles')->find($id);
        return response($Employee);
    }

    public function destroy($id)
    {
        Employee::find($id)->delete();

    }
}
