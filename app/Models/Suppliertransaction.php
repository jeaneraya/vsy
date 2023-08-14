<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliertransaction extends Model
{
    use HasFactory;
    protected $table = 'supplier_transactions';
    protected $fillable = [
        'trans_date',
        'supplier_id',
        'ref_no',
        'trans_description',
        'payments',
        'charges',
        'balance',
        'remarks'
    ];
}
