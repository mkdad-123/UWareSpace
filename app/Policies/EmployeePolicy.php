<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Admin;

class EmployeePolicy
{


    /**
     * Determine whether the Admin can update the model.
     */
    public function update(Admin $admin, Employee $employee): bool
    {
        return $admin->id === $employee->admin_id;
    }

    /**
     * Determine whether the Admin can delete the model.
     */
    public function delete(Admin $admin, Employee $employee): bool
    {
        return $admin->id === $employee->admin_id;
    }

}
