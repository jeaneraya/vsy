<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Constants
{
    public static function getAccountStatusValue()
    {
        return [
            0 => 'Pending',
            1 => 'Approved',
            2 => 'Rejected',
        ];
    }

    public static function getRoleValue()
    {
        return [
            1 => 'Super Admin',
            2 => 'Admin',
            3 => 'Collector'
        ];
    }


    public static function getEmployeeStatus()
    {
        return [
            1 => 'Contractual',
            2 => 'Floating',
            3 => 'OJT',
            4 => 'Regular',
            5 => 'Temporary'
        ];
    }

    public static function getHiringStatus()
    {
        return [
            0 => 'Hired',
            1 => 'Resigned',
        ];
    }

    public static function getRemindersStatus()
    {
        return [
            0 => 'Pending',
            1 => 'Sent',
            2 => 'Failed',
            3 => 'Cancelled'
        ];
    }

    public static function getRemindersTypes()
    {
        return [
            1 => 'Custom',
            2 => 'Template',
            3 => 'Birthday',
            4 => 'Renewal',
            5 => 'Registration',
            6 => 'Insurance'
        ];
    }

    public static function getPayrollClaimed()
    {
        return [
            0 => 'NO',
            1 => 'YES'
        ];
    }
}
