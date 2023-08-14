<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientproduct extends Model
{
    use HasFactory;
    protected $table = 'clients_products';
    protected $fillable = [
        'description',
        'unit',
        'price',
        'status'
    ];
}
