<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplierproduct extends Model
{
    use HasFactory;
    protected $table = 'supplier_products';
    protected $fillable = [
        "item_code",
        "item_description",
        "unit",
        "price",
        "status"
    ];
}
