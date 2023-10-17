<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clienttransaction extends Model
{
    use HasFactory;
    protected $table = 'clients_transactions';
    protected $fillable = [
        'trans_date',
        'client_id',
        'ref_no',
        'trans_description',
        'payments',
        'charges',
        'or_num_charges',
        'balance',
        'remarks'
    ];
}
