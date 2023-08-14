<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplierpayment extends Model
{
    use HasFactory;
    protected $table = 'supplier_payments';
    protected $fillable = [
        'payment_date',
        'trans_id',
        'supplier_id',
        'amount_paid',
        'balance'
    ];
}
