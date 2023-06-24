<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $fillable = [
        'employee_code',
        'fullname',
        'birthday',
        'address',
        'contact',
        'date_hired',
        'date_resigned',
        'position',
        'rate_per_day',
        'overtime_pay',
        'interest',
        'ctc_number',
        'place_issued',
        'date_issued',
        'status',
        'hiring_status',
        'created_by',
    ];


}
