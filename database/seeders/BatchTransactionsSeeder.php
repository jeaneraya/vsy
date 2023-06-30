<?php

namespace Database\Seeders;

use App\Models\Batchtransaction;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BatchTransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Batchtransaction::create([
            'num' => '1',
            'period_from' => '2023-01-01',
            'period_to' => '2023-01-01',
            'collector_id' => '3',
            'remarks' => '',
            'first_collection' => Carbon::now()->format('Y-m-d'),
            'addon_interest' => '0',
            'status' => 'active',
        ]);


        Batchtransaction::create([
            'num' => '2',
            'period_from' => '2023-01-01',
            'period_to' => '2023-01-01',
            'collector_id' => '3',
            'remarks' => '',
            'first_collection' => Carbon::now()->format('Y-m-d'),
            'addon_interest' => '0',
            'status' => 'active',
        ]);


        Batchtransaction::create([
            'num' => '3',
            'period_from' => '2023-01-01',
            'period_to' => '2023-01-01',
            'collector_id' => '3',
            'remarks' => '',
            'first_collection' => Carbon::now()->format('Y-m-d'),
            'addon_interest' => '0',
            'status' => 'active',
        ]);
        Batchtransaction::create([
            'num' => '1',
            'period_from' => '2023-01-01',
            'period_to' => '2023-01-01',
            'collector_id' => '3',
            'remarks' => '',
            'first_collection' => Carbon::now()->format('Y-m-d'),
            'addon_interest' => '0',
            'status' => 'active',
        ]);
        Batchtransaction::create([
            'num' => '2',
            'period_from' => '2023-01-01',
            'period_to' => '2023-01-01',
            'collector_id' => '4',
            'remarks' => '',
            'first_collection' => Carbon::now()->format('Y-m-d'),
            'addon_interest' => '0',
            'status' => 'active',
        ]);


    }
}
