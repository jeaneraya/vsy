<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        Role::create(['id'=> 1, 'name' => 'SuperAdmin', 'for_registration' => 1]);
        Role::create(['id'=> 2, 'name' => 'Admin', 'for_registration' => 1]);
        Role::create(['id'=> 3, 'name' => 'Collector', 'for_registration' => 0]);
        Role::create(['id'=> 4, 'name' => 'Area Manager', 'for_registration' => 1]);
    }
}
