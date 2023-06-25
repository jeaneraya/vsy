<?php

namespace Database\Seeders;

use App\Models\PayrollComputations;
use Illuminate\Database\Seeder;

class PayrollComputationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        PayrollComputations::create([
            'payroll_schedule_id' => '1',
            'employee_id' => '1',
            'rate_per_day' => '10',
            'hours_overtime' => '1',
            'hours_late' => '2',
            'days_absent' => '1',
            'days_present' => '10',
            'deductions_list' => '{"fixed": ["pagibig", "sss", "undertime", "absent"], "custom":[]}',
            'bonus' => '10',
            'total_deductions' => '20',
            'gross_pay' => '100',
            'net_pay' => '105',
            'status' => '0',
            'is_claimed' => '0',
            'date_claimed' => null,
        ]);

        PayrollComputations::create([
            'payroll_schedule_id' => '2',
            'employee_id' => '2',
            'rate_per_day' => '10',
            'hours_overtime' => '1',
            'hours_late' => '2',
            'days_absent' => '1',
            'days_present' => '10',
            'deductions_list' => '{"fixed": ["pagibig", "sss", "undertime", "absent"], "custom":[]}',
            'bonus' => '10',
            'total_deductions' => '20',
            'gross_pay' => '100',
            'net_pay' => '105',
            'status' => '0',
            'is_claimed' => '0',
            'date_claimed' => null,
        ]);

        PayrollComputations::create([
            'payroll_schedule_id' => '1',
            'employee_id' => '3',
            'rate_per_day' => '10',
            'hours_overtime' => '1',
            'hours_late' => '2',
            'days_absent' => '1',
            'days_present' => '10',
            'deductions_list' => '{"fixed": ["pagibig", "sss", "undertime", "absent"], "custom":[]}',
            'bonus' => '10',
            'total_deductions' => '20',
            'gross_pay' => '100',
            'net_pay' => '105',
            'status' => '0',
            'is_claimed' => '0',
            'date_claimed' => null,
        ]);

    }
}
