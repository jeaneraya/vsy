<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemindersLogger extends Model
{
    use HasFactory;
    protected $fillable = [
        'reminder_id',
        'sent_datetime',
        'description',
        'sent_to',
        'message',
        'sent_via',
        'schedule',
        'is_read',
        'type'
    ];
}
