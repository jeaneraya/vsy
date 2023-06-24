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
            'schedule' => Carbon::now()->addDay(2),
            'template_id' => '0',
            'type' => '4',
            'status' => '0',
            'created_by' => '1',
        ]);

        Reminder::create([
            'description' => 'Tomorrow',
            'schedule' => Carbon::now()->addDay(2),
            'template_id' => '0',
            'type' => '3',
            'status' => '1',
            'created_by' => '1',
        ]);

        Reminder::create([
            'description' => 'Birthday',
            'schedule' => Carbon::now()->addDay(2),
            'template_id' => '0',
            'type' => '2',
            'status' => '2',
            'created_by' => '1',
        ]);

        Reminder::create([
            'description' => 'Due',
            'schedule' => Carbon::now()->addDay(2),
            'template_id' => '0',
            'type' => '5',
            'status' => '3',
            'created_by' => '1',
        ]);

    }
}
