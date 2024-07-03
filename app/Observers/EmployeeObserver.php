<?php

namespace App\Observers;

use App\Models\Employee;

class EmployeeObserver
{
    public function created(Employee $employee): void
    {

    }

    public function updated(Employee $employee): void
    {
    }

    public function deleted(Employee $employee): void
    {
    }

    public function restored(Employee $employee): void
    {
    }

    public function forceDeleted(Employee $employee): void
    {
    }
}
