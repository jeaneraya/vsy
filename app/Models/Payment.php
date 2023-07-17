<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'batch_id',
        'collector_id',
        'payment_sched',
        'payment_date',
        'days',
        'amount',
        'amount',
        'paid_amount',
        'balance',
        'mop',
        'mop_details',
    ];
}
