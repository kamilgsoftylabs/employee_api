<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeDelegationRequest;
use App\Jobs\CreateEmployeeDelegationJob;
use App\Models\Employee;
use App\Traits\ResponseJson;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;

class EmployeeDelegationsController extends Controller
{
    use DispatchesJobs, ResponseJson;

    /**
     * Store employee delegation in storage.
     */
    public function store(CreateEmployeeDelegationRequest $request, Employee $employee)
    {
        // Get validated data from request.
        $data = $request->validated();

        // Get last delegation of given employee.
        $latestDelegation = $employee->delegations->last();

        // Check if employee has delegation in given time.
        if(isset($latestDelegation) && !Carbon::parse($latestDelegation->end_date)->isPast() && Carbon::parse($data['start_date'])->between($latestDelegation->start_date, $latestDelegation->end_date)) {
            return $this->error('Employee delegation already exists for this period.');
        }

        // Dispatch job to store employee delegation in storage.
        $employeeDelegations = $this->dispatchSync(new CreateEmployeeDelegationJob($data, $employee));

        // Return response.
        return $this->success('Employee delegation created successfully.', $employeeDelegations->toArray());
    }
}
