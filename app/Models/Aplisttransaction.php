<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aplisttransaction extends Model
{
    use HasFactory;
    protected $table = 'aplist_transactions';
    protected $fillable = [
        'ap_id',
        'schedule_date',
        'amount_payable',
        'amount_paid',
        'remarks',
        'balance',
        'post_status',
        'type',
        'bank',
        'check_num'
    ];
}
