<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchDelivery extends Model
{
    use HasFactory;
    protected $table = 'batch_deliveries';
    protected $fillable = [
        'batch_id',
        'collector_id',
        'dr_num',
        'date_withdrawn',
        'remarks',
        'amount'
    ];
}
