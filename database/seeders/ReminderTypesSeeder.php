<?php

namespace Database\Seeders;

use App\Models\ReminderTypes;
use Illuminate\Database\Seeder;

class ReminderTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReminderTypes::truncate();
        ReminderTypes::create([
            'id' => '1',
            'name' => 'Custom',
            'description' => 'Custom'
        ]);

        ReminderTypes::create([
            'id' => '2',
            'name' => 'Template',
            'description' => 'Template'
        ]);

        ReminderTypes::create([
            'id' => '3',
            'name' => 'Birthday',
            'description' => 'Birthday'
        ]);

        ReminderTypes::create([
            'id' => '4',
            'name' => 'Renewal',
            'description' => 'Renewal'
        ]);

        ReminderTypes::create([
            'id' => '5',
            'name' => 'Insurance',
            'description' => 'Insurance'
        ]);
    }
}
