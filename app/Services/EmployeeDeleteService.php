<?php

namespace App\Services;

use App\ResponseManger\OperationResult;
use DB;
use Exception;

class EmployeeDeleteService
{
    protected OperationResult $result;

    public function delete($employee)
    {
        try {
            DB::beginTransaction();

            $employee->load('phones');

            $employee->phones()->delete();

            $employee->delete();

            DB::commit();

            $this->result = new OperationResult( 'Your employee has been deleted successfully',response());

        } catch (Exception $e) {

            DB::rollBack();

            return $this->result = new OperationResult( 'Failed to delete employee: ' . $e->getMessage(), response(),500);
        }
        return $this->result;
    }

}
