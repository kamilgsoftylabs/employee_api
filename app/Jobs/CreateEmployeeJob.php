<?php

namespace App\Jobs;

use App\Models\Employee;

final class CreateEmployeeJob
{
	private array $validatedData;

	public function __construct(array $validatedData)
	{
		$this->validatedData = $validatedData;
	}

	/**
	 * Execute the job.
	 */
	public function handle(): Employee
	{
		$employeesModel = new Employee();
		$employeesModel->fill($this->validatedData);
		$employeesModel->save();

		return $employeesModel;
	}
}
