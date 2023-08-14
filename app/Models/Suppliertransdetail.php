<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliertransdetail extends Model
{
    use HasFactory;
    protected $table = 'supplier_trans_details';
    protected $fillable = [
        'supplier_trans_id',
        'product_id',
        'qty',
        'total'
    ];
}
