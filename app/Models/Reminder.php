<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;
    protected $table = 'reminders';
    protected $fillable = [
        'description',
        'schedule',
        'template_id',
        'type',
        'status',
        'created_by',
        'frequency',
        'is_active'
    ];
}
