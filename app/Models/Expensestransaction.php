<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expensestransaction extends Model
{
    use HasFactory;
    protected $table = 'expensestransactions';
    protected $fillable = [
        'batch_num',
        'collector_id',
        'expenses_id',
        'amount',
    ];
}
