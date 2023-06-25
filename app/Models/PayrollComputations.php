<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollComputations extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_schedule_id',
        'employee_id',
        'rate_per_day',
        'hours_overtime',
        'hours_late',
        'days_absent',
        'days_present',
        'deductions_list',
        'bonus',
        'total_deductions',
        'gross_pay',
        'net_pay',
        'status',
        'is_claimed',
        'date_claimed',
    ];
}
