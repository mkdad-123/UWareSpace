<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Admin;

class EmployeePolicy
{
    /**
     * Determine whether the Admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        //
    }

    /**
     * Determine whether the Admin can view the model.
     */
    public function view(Admin $admin, Employee $employee): bool
    {
        //
    }

    /**
     * Determine whether the Admin can create models.
     */
    public function create(Admin $admin): bool
    {
        //
    }

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

    /**
     * Determine whether the Admin can restore the model.
     */
    public function restore(Admin $admin, Employee $employee): bool
    {
        //
    }

    /**
     * Determine whether the Admin can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Employee $employee): bool
    {
        //
    }
}
