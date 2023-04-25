<?php

namespace App\Queries;

use App\Models\EmployeeDelegations;
use App\Models\Employee;
use Illuminate\Support\Collection;

final class EmployeeDelegationsQueries
{
    /**
     * Get delegations for employee.
     */
    public static function getDelegationsForEmployee(Employee $employee): Collection
    {
        return $employee->delegations()
            ->select('start_date', 'end_date', 'country', 'amount_due', 'currency')
            ->get();
    }
}
