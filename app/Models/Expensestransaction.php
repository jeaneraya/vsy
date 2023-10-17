<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expensestransaction extends Model
{
    use HasFactory;
    protected $table = 'expensestransactions';
    protected $fillable = [
        'batch_id',
        'delivery_id',
        'expenses_id',
        'remarks',
        'amount',
    ];
}
