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
            'name' => 'Insurance',
            'description' => 'Insurance',
            'type' => '1' // custom

        ]);

        ReminderTypes::create([
            'id' => '2',
            'name' => 'Registration',
            'description' => 'Registration',
            'type' => '1' // custom
        ]);
        ReminderTypes::create([
            'id' => '3',
            'name' => 'Custome',
            'description' => 'Custom',
            'type' => '1' // custom
        ]);

        ReminderTypes::create([
            'id' => '4',
            'name' => '1st Collection',
            'description' => '1st Collection',
            'type' => '0' // automated
        ]);

        ReminderTypes::create([
            'id' => '5',
            'name' => '15th Collection',
            'description' => '15th Collection',
            'type' => '0' // automated
        ]);

        ReminderTypes::create([
            'id' => '6',
            'name' => 'End Of Month Collection',
            'description' => 'End Of Month Collection',
            'type' => '0' // automated
        ]);

        ReminderTypes::create([
            'id' => '7',
            'name' => 'Birthday',
            'description' => 'Birthday',
            'type' => '0' // automated
        ]);


    }
}
