<?php

namespace App\Relations;

use App\Models\EmployeeDelegations;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyDelegations
{
    /**
     * Get latest measurements.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function delegations(): HasMany
    {
        return $this->hasMany(EmployeeDelegations::class);
    }
}
