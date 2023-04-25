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
    public static function getLast(): int|null
    {
        return Employee::get()->last()->id;
    }
}
