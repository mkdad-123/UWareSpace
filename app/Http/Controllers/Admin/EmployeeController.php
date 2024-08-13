<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeStoreRequest;
use App\Http\Requests\Employee\EmployeeUpdateRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Services\Employee\EmployeeStoreService;
use App\Services\Employee\EmployeeUpdateService;
use App\Services\EmployeeDeleteService;
use Spatie\Permission\Models\Role;


class EmployeeController extends Controller
{

    public function show()
    {
        $adminId = auth('admin')->id();

        $employees = Employee::with(['phones' , 'roles'])->whereAdminId($adminId)->get();

        return $this->response(EmployeeResource::collection($employees));
    }

    public function store(EmployeeStoreRequest $request , EmployeeStoreService $storeService)
    {
        $result = $storeService->store($request);

        return $this->response(
            $result->data,
            $result->message,
            $result->status
        );
    }

    public function showOne($id)
    {
        $employee = Employee::find($id);
        $employee->load(['phones' , 'roles']);

        return $this->response(new EmployeeResource($employee));
    }

    public function update(EmployeeUpdateRequest $request, Employee $employee ,EmployeeUpdateService $updateService)
    {
        $result = $updateService->update($request , $employee);

        if ( $result->status == 200){
            return $this->response(
                new EmployeeResource($result->data),
                $result->message,
                $result->status,
            );
        }
        return  $this->response(
            $result->data,

            $result->message,
            $result->status,
        );
    }

    public function destroy(Employee $employee , EmployeeDeleteService $deleteService)
    {
        $this->authorize('delete', $employee);

        $result = $deleteService->delete($employee);

        return  $this->response(
            $result->data,
            $result->message,
            $result->status,
        );
    }
}
