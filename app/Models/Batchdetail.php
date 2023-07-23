<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batchdetail extends Model
{
    use HasFactory;
    protected $table = 'batchdetails';
    protected $fillable = [
        'batch_num',
        'ref_no',
        'product_id',
        'qty',
        'total_amount',
        'return_qty',
        'date_delivered',
        'date_returned'
    ];
}
