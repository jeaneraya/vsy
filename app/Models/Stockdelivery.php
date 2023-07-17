<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stockdelivery extends Model
{
    use HasFactory;
    protected $table = 'stockdeliveries';
    protected $fillable = [
        'covered_date',
        'am_id',
        'description',
        'dr_num',
        'total_delivery',
        'amount_paid',
        'cutoff_date',
        'balance',
        'credit_limit',
    ];
}
