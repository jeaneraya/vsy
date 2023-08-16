<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clienttransdetail extends Model
{
    use HasFactory;
    protected $table = 'clients_transdetails';
    protected $fillable = [
        'client_trans_id',
        'product_id',
        'qty',
        'total'
    ];
}
