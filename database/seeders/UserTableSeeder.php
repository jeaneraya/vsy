<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();

        $superAdminRole = Role::where(['name' => 'superadmin'])->first();
        $admin = Role::where(['name' => 'admin'])->first();
        $collector = Role::where(['name' => 'collector'])->first();

        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@test.com',
            'password' => Hash::make('Testing123'),
            'birthday' => '2023-01-01',
            'contact' => 12345678912,
            'address' => 'test address',
            'role' => 1
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('Testing123'),
            'birthday' => '2023-01-01',
            'contact' => 12345678912,
            'address' => 'test address',
            'role' => 2
        ]);

        $collector = User::create([
            'name' => 'Collector',
            'email' => 'collector@test.com',
            'password' => Hash::make('Testing123'),
            'birthday' => '2023-01-01',
            'contact' => 12345678912,
            'address' => 'test address',
            'role' => 3
        ]);
    }
}
