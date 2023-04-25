<?php

namespace App\Queries;

use App\Models\Employee;

final class EmployeesQueries
{

    /**
     * Get the last employee id.
     *
     * @return mixed
     */
    public static function getLast(): ?Employee
    {
        return Employee::get()->last();
    }
}
