<?php

namespace App\Models;

use App\Relations\BelongsToEmployee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDelegations extends Model
{
    use HasFactory, BelongsToEmployee;

    const PL = 10;
    const DE = 50;
    const GB = 75;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'start_date', 'end_date', 'country', 'amount_due'
    ];

}
