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
            'name' => '1st Collection',
            'description' => '1st Collection'
        ]);

        ReminderTypes::create([
            'id' => '2',
            'name' => '15th Collection',
            'description' => '15th Collection'
        ]);

        ReminderTypes::create([
            'id' => '3',
            'name' => '30th/31st Collection',
            'description' => '30th/31st Collection',
        ]);

        ReminderTypes::create([
            'id' => '4',
            'name' => 'Birthday',
            'description' => 'Birthday'
        ]);

        ReminderTypes::create([
            'id' => '5',
            'name' => 'Insurance',
            'description' => 'Registration'
        ]);

        ReminderTypes::create([
            'id' => '6',
            'name' => 'Custom',
            'description' => 'Custom'
        ]);
    }
}
