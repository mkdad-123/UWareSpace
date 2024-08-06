<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeStoreRequest;
use App\Http\Requests\Employee\EmployeeUpdateRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\Plan;
use App\Services\Employee\EmployeeStoreService;
use App\Services\Employee\EmployeeUpdateService;
use App\Services\EmployeeDeleteService;


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
    $admin = auth('admin')->user()->id;
        $plan = Plan::where('name', 'gold')->pluck('num_of_employees');
        if (Employee::where('admin_id', $admin)->count() <= $plan){
            $result = $storeService->store($request);
            return $this->response(
                $result->data,
                $result->message,
                $result->status
            );
        }
        else{
            return response()->json([
                'message' => "You have reached the maximum number of employees. If you would like to add more, subscribe to a plan that allows for a larger number of employees, please",
            ]);
        }
    }

    public function showOne(Employee $employee)
    {
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
