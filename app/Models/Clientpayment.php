<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientpayment extends Model
{
    use HasFactory;
    protected $table = 'client_payments';
    protected $fillable = [
        'payment_date',
        'client_id',
        'trans_id',
        'amount_paid',
        'balance'
    ];
}
