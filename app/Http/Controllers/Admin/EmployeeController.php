<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\Phone;
use App\Services\EmployeeStoreService;
use App\Services\EmployeeUpdateService;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{

    public function show()
    {
        $adminId = auth('admin')->id();

        $employees = Employee::with('phones')->whereAdminId($adminId)->get();

        return $this->response(EmployeeResource::collection($employees));
    }

    public function store(EmployeeStoreRequest $request)
    {
        $result = (new EmployeeStoreService())->store($request);

        return $this->response(
            $result->data,
            $result->message,
            $result->status
        );
    }

    public function showOne($id)
    {
        $employee = Employee::with(['roles','phones'])->find($id);

        return $this->response(new EmployeeResource($employee));
    }

    public function update(EmployeeUpdateRequest $request, $id)
    {

        $result = (new EmployeeUpdateService())->update($request , $id);

        return $this->response(
            new EmployeeResource($result->data),
            $result->message,
            $result->status
        );
   }

    public function destroy($id)
    {
        Employee::with('phones')->find($id)->delete();

        return $this->response(response());
    }
}
