<?php

namespace App\Http\Controllers;

use App\Jobs\CreateEmployeeJob;
use App\Models\Employee;
use App\Queries\EmployeeDelegationsQueries;
use App\Queries\EmployeesQueries;
use App\Http\Requests\CreateEmployeeRequest;
use App\Traits\ResponseJson;
use Illuminate\Foundation\Bus\DispatchesJobs;

class EmployeesController extends Controller
{
	use DispatchesJobs, ResponseJson;

    /**
     * Store new employee in storage.
     */
	public function store(CreateEmployeeRequest $request)
	{
		// Get validated data from request.
		$validatedData = $request->validated();

        // If payload is empty then return latest id of stored employee.
		if ($request->isNotFilled('name')) {
			return response()->json([
				'id' => EmployeesQueries::getLast(),
			]);
		}

		// Dispatch job to store employee in storage.
		$employee = $this->dispatchSync(new CreateEmployeeJob($validatedData));

        // Return response.
		return $this->success('Employee deleted successfully.', $employee->toArray());
	}

    /**
     * Show employee.
     */
    protected function show(Employee $employee)
    {
        // Get delegations for employee.
        $employeeDelegations = EmployeeDelegationsQueries::getDelegationsForEmployee($employee);

        // Return response.
        return response()->json($employeeDelegations);
    }

}
