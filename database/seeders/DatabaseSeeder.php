<?php

namespace Database\Seeders;

use App\Models\ReminderTypes;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(RemindersSeeder::class);
        $this->call(ReminderTypesSeeder::class);
        $this->call(PayrollSchedulesSeeder::class);
        $this->call(PayrollComputationsSeeder::class);
        $this->call(BatchTransactionsSeeder::class);
        $this->call(PaymentsSeeder::class);
    }
}
