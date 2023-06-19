<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batchtransaction extends Model
{
    use HasFactory;
    protected $table = 'batchtransactions';
    protected $fillable = [
        'num',
        'period_from',
        'collector_id',
        'period_to',
        'first_collection',
        'remarks',
        'addon_interest',
        'status',
    ];
}
