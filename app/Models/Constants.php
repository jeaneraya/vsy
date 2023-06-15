<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Constants
{
    public static function getAccountStatusValue() {
        return [
            0 => 'Pending',
            1 => 'Approved',
            2 => 'Rejected',
        ];
    }

    public static function getRoleValue() {
        return [
            1 => 'Super Admin',
            2 => 'Admin',
            3 => 'Collector'
        ];
    }
}
