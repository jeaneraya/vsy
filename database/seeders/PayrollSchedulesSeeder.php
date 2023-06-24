<?php

namespace Database\Seeders;

use App\Models\PayrollSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PayrollSchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->addMonth(1);
        $nextMonth = Carbon::now()->addMonth(2);
        PayrollSchedule::create([
            'name' => $now->format('Y M') . " 1-15",
            'description' => 'Test',
            'from' => $now->format('Y-m-01'),
            'to' => $now->format('Y-m-15'),
            'created_by' => 1,
            'status' => 1
        ]);

        PayrollSchedule::create([
            'name' => $now->format('Y M') ." 1-16",
            'description' => 'Test',
            'from' => $now->format('Y-m-01'),
            'to' => $now->format('Y-m-30'),
            'created_by' => 1,
            'status' => 1
        ]);

        PayrollSchedule::create([
            'name' => $nextMonth->format('Y M') . " 1-15",
            'description' => 'Test',
            'from' => $nextMonth->format('Y-m-01'),
            'to' => $nextMonth->format('Y-m-15'),
            'created_by' => 1,
            'status' => 1
        ]);

        PayrollSchedule::create([
            'name' => $nextMonth->format('Y M') ." 1-16",
            'description' => 'Test',
            'from' => $nextMonth->format('Y-m-01'),
            'to' => $nextMonth->format('Y-m-30'),
            'created_by' => 1,
            'status' => 1
        ]);

    }
}
