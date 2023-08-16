<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    use HasFactory;
    protected $table = 'collectors';
    protected $fillable = [
        'user_id',
        'code',
        'fullname',
        'mobile',
        'address',
        'cashbond',
        'id_num',
        'spouse',
        'row_status'
    ];
}
