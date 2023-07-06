<?php

namespace Database\Seeders;

use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RemindersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reminder::create([
            'description' => 'TOday onetime',
            'schedule' => Carbon::now()->format('Y-m-d'),
            'template_id' => '0',
            'type' => '4',
            'frequency' => '1',
            'status' => '0',
            'created_by' => '1',
            'message' => 'This is message 1'
        ]);

        Reminder::create([
            'description' => 'TOday 1 onetime',
            'schedule' => Carbon::now()->format('Y-m-d'),
            'template_id' => '0',
            'type' => '4',
            'frequency' => '1',
            'status' => '0',
            'created_by' => '1',
            'message' => 'This is message 2'
        ]);


        Reminder::create([
            'description' => 'TOday 2 onetime',
            'schedule' => Carbon::now()->format('Y-m-d'),
            'template_id' => '0',
            'type' => '4',
            'frequency' => '1',
            'created_by' => '1',
            'status' => '0',
            'message' => 'This is message 3'
        ]);


        Reminder::create([
            'description' => 'Tomorrow daily',
            'schedule' => Carbon::now()->addDay(2)->format('Y-m-d'),
            'template_id' => '0',
            'type' => '3',
            'frequency' => '2',
            'status' => '0',
            'created_by' => '1',
            'message' => 'This is message 4'
        ]);

        Reminder::create([
            'description' => 'weekly',
            'schedule' => Carbon::now()->subWeek(1),
            'template_id' => '0',
            'type' => '2',
            'frequency' => '3',
            'status' => '0',
            'created_by' => '1',
            'message' => 'This is message 5'
        ]);

        Reminder::create([
            'description' => 'Monthly',
            'schedule' => Carbon::now()->subMonth(1),
            'template_id' => '0',
            'type' => '3',
            'frequency' => '4',
            'status' => '0',
            'created_by' => '1',
            'message' => 'This is message 6'
        ]);


        Reminder::create([
            'description' => 'yearly',
            'schedule' => Carbon::now()->subYears(1),
            'template_id' => '0',
            'type' => '3',
            'frequency' => '5',
            'status' => '0',
            'created_by' => '1',
            'message' => 'This is message 7'
        ]);

    }
}
