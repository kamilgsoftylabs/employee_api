<?php

namespace App\Jobs;

use App\Models\Employee;

final class CreateEmployeeJob
{
    /**
        * @var array
     */
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): Employee
    {
        $employeesModel = new Employee();
        $employeesModel->fill($this->data);
        $employeesModel->save();

        return $employeesModel;
    }

}
