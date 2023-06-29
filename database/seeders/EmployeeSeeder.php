<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positionSamples = [
            'President',
            'Vice President',
            'Auditor',
            'Manager',
        ];


        DB::table('employees')->insert([
            'employee_code' => Str::random(3),
            'fullname' => Str::random(10),
            'birthday' => Carbon::now()->format('1996-m-d'),
            'address' => Str::random(10),
            'contact' => '091111111111',
            'date_hired' => Carbon::now()->format('Y-m-d'),
            'date_resigned' => null,
            'position' => $positionSamples[rand(0,3)],
            'rate_per_day' => 10,
            'overtime_pay' => 2,
            'interest' => 3,
            'ctc_number' => 111,
            'place_issued' => 'Place holder',
            'date_issued' => Carbon::now()->format('Y-m-d'),
            'status' => rand(0,4),
            'created_by' => 1
        ]);

        DB::table('employees')->insert([
            'employee_code' => Str::random(3),
            'fullname' => Str::random(10),
            'birthday' => Carbon::now()->format('1996-m-d'),
            'address' => Str::random(10),
            'contact' => '091111111111',
            'date_hired' => Carbon::now()->format('Y-m-d'),
            'date_resigned' => null,
            'position' => $positionSamples[rand(0,3)],
            'rate_per_day' => 20,
            'overtime_pay' => 2,
            'interest' => 3,
            'ctc_number' => 111,
            'place_issued' => 'Place holder',
            'date_issued' => Carbon::now()->format('Y-m-d'),
            'status' => rand(0,4),
            'created_by' => 1
        ]);

        DB::table('employees')->insert([
            'employee_code' => Str::random(3),
            'fullname' => Str::random(10),
            'birthday' => Carbon::now()->format('1996-m-d'),
            'address' => Str::random(10),
            'contact' => '091111111111',
            'date_hired' => Carbon::now()->format('Y-m-d'),
            'date_resigned' => null,
            'position' => $positionSamples[rand(0,3)],
            'rate_per_day' => 30,
            'overtime_pay' => 2,
            'interest' => 3,
            'ctc_number' => 111,
            'place_issued' => 'Place holder',
            'date_issued' => Carbon::now()->format('Y-m-d'),
            'status' => rand(0,4),
            'created_by' => 1
        ]);
    }
}
