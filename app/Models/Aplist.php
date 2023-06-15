<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aplist extends Model
{
    use HasFactory;
    protected $table = 'aplists';
    protected $fillable = [
        'name',
        'remarks',
        'status'
    ];
}
