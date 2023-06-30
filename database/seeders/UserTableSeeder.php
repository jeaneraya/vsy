<?php

namespace Database\Seeders;

use App\Models\Collector;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
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
            'birthday' => Carbon::now()->format('Y-m-d'),
            'contact' => 12345678912,
            'address' => 'test address',
            'role' => 1,
            'approval_status' => '1'
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('Testing123'),
            'birthday' => Carbon::now()->format('Y-m-d'),
            'contact' => 12345678912,
            'address' => 'test address',
            'role' => 2,
            'approval_status' => '1'
        ]);

        $collector = User::create([
            'name' => 'Collector',
            'email' => 'collector@test.com',
            'password' => Hash::make('Testing123'),
            'birthday' => '2023-01-01',
            'contact' => 12345678912,
            'address' => 'test address',
            'role' => 3,
            'approval_status' => '0'
        ]);

        $areaManager = User::create([
            'name' => 'Area Manager',
            'email' => 'areaManager@test.com',
            'password' => Hash::make('Testing123'),
            'birthday' => '2023-01-01',
            'contact' => 12345678912,
            'address' => 'test address',
            'role' => 4,
            'approval_status' => '0'
        ]);

        Collector::create([
            'user_id' => $collector->id,
            'code' => 1,
            'cashbond' => 2,
            'ctc_no' => 3,
            'status' => 1
        ]);

        Collector::create([
            'user_id' => $areaManager->id,
            'code' => 1,
            'cashbond' => 2,
            'ctc_no' => 3,
            'status' => 1
        ]);
    }
}
