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
            'description' => 'TOday',
            'schedule' => Carbon::now(),
            'template_id' => '0',
            'type' => '4',
            'frequency' => '1',
            'status' => '0',
            'created_by' => '1',
            'message' => 'This is message 1'
        ]);

        Reminder::create([
            'description' => 'TOday 1',
            'schedule' => Carbon::now(),
            'template_id' => '0',
            'type' => '4',
            'frequency' => '1',
            'status' => '0',
            'created_by' => '1',
            'message' => 'This is message 2'
        ]);


        Reminder::create([
            'description' => 'TOday 2',
            'schedule' => Carbon::now(),
            'template_id' => '0',
            'type' => '4',
            'frequency' => '1',
            'created_by' => '1',
            'status' => '0',
            'message' => 'This is message 3'
        ]);


        Reminder::create([
            'description' => 'Tomorrow',
            'schedule' => Carbon::now()->addDay(2),
            'template_id' => '0',
            'type' => '3',
            'frequency' => '2',
            'status' => '1',
            'created_by' => '1',
            'message' => 'This is message 4'
        ]);

        Reminder::create([
            'description' => 'Birthday',
            'schedule' => Carbon::now()->addDay(2),
            'template_id' => '0',
            'type' => '2',
            'frequency' => '3',
            'status' => '2',
            'created_by' => '1',
            'message' => 'This is message 5'
        ]);

        Reminder::create([
            'description' => 'Due',
            'schedule' => Carbon::now()->addDay(2),
            'template_id' => '0',
            'type' => '5',
            'frequency' => '4',
            'status' => '3',
            'created_by' => '1',
            'message' => 'This is message 6'
        ]);

    }
}
