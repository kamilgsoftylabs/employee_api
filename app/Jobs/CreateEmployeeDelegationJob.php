<?php

namespace App\Jobs;

use App\Models\Employee;
use App\Models\EmployeeDelegations;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

final class CreateEmployeeDelegationJob
{
    /**
        * @var array
     */
    private array $validatedData;
    private Employee $employee;

    public function __construct(array $validatedData, Employee $employee)
    {
        $this->validatedData = $validatedData;
        $this->employee = $employee;
    }

    /**
     * Execute the job.
     */
    public function handle(): EmployeeDelegations
    {
        // Create new delegation.
        $employeeDelegations = new EmployeeDelegations();

        $employeeDelegations->fill($this->validatedData);
        $employeeDelegations->employee_id = $this->employee->id;
        $employeeDelegations->currency = 'PLN';

        // Calculate amount due.
        $employeeDelegations->amount_due = $this->calculateAmountDue();

        // Save delegation.
        $employeeDelegations->save();

        // Return delegation with specified fields.
        return $employeeDelegations->select('start_date', 'end_date', 'country', 'amount_due', 'currency')
            ->get()->last();
    }

    /**
     * Calculate amount due.
     */
    private function calculateAmountDue(): int
    {
        $requiredHours = 8;

        $startHour = Carbon::parse($this->validatedData['start_date'])->hour;
        $endHour = Carbon::parse($this->validatedData['end_date'])->hour;
        $removeDateEnd = null;
        $removeDateStart = null;

        // Check if start hour is mixes in required hours.
        if(($startHour + $requiredHours) > 24) {
            $removeDateStart = Carbon::parse($this->validatedData['start_date'])->format('Y-m-d');
        }

        // Check if end hour is mixes in required hours.
        if(($endHour + $requiredHours) > 24) {
            $removeDateEnd = Carbon::parse($this->validatedData['end_date'])->format('Y-m-d');
        }

        // Generate dates between start and end date.
        $dateRange = CarbonPeriod::create(Carbon::parse($this->validatedData['start_date'])->format('Y-m-d'), Carbon::parse($this->validatedData['end_date'])->format('Y-m-d'));
        $dates = array_map(fn ($date) => ['date' => $date->format('Y-m-d')], iterator_to_array($dateRange));

        // Get amount for given country and calculate.
        $country = $this->validatedData['country'];

        // Remove start and or date when employee not pass required hours in day (8).
        foreach($dates as $key => $row) {
            if($row['date'] == $removeDateStart || $row['date'] == $removeDateEnd || Carbon::parse($row['date'])->isWeekend()) {
                unset($dates[$key]);
            }

        }

        // Calculate amount due for each day.
        foreach($dates as $key => $date) {
            // If loop+1 is greater than 7 then multiply by 2.
            $dates[$key]['amount_due'] = ($key+1) > 7 ? constant("\App\Models\EmployeeDelegations::$country") * 2 : constant("\App\Models\EmployeeDelegations::$country");
        }

        // sum amount_due.
        return collect($dates)->sum('amount_due');
    }
}
