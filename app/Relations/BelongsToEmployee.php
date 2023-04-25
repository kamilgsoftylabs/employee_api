<?php

namespace App\Relations;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToEmployee
{
	/**
	 * Has many delegations.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function employee(): BelongsTo
	{
		return $this->belongsTo(Employee::class);
	}
}
