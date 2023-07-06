<?php

namespace Database\Seeders;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentDate =  Carbon::now()->format('d') > 15 ? 15 : Carbon::now()->endOfMonth()->format('d');
        Payment::create(
            [
                'batch_id' => '1',
                'collector_id' => '3',
                'payment_sched' => Carbon::now()->subMonth(2)->format("Y-m-{$paymentDate}"),
                'payment_date' => Carbon::now()->subMonth(2)->format('Y-m-d'),
                'days' => '0',
                'amount' => '100',
                'paid_amount' => '100',
                'balance' => '700',
                'mop' => '',
                'mop_details' => ''
            ]
        );

        Payment::create(
            [
                'batch_id' => '1',
                'collector_id' => '3',
                'payment_sched' => Carbon::now()->format("Y-m-{$paymentDate}"),
                'payment_date' => Carbon::now()->subMonth(1)->addDays(1)->format('Y-m-d'),
                'days' => '0',
                'amount' => '100',
                'paid_amount' => '100',
                'balance' => '200',
                'mop' => '',
                'mop_details' => ''
            ]
        );

        Payment::create(
            [
                'batch_id' => '3',
                'collector_id' => '4',
                'payment_sched' => Carbon::now()->subMonth(2)->format("Y-m-{$paymentDate}"),
                'payment_date' => Carbon::now()->subMonth(2) ->addDays(2)->format('Y-m-d'),
                'days' => '0',
                'amount' => '100',
                'paid_amount' => '100',
                'balance' => '500',
                'mop' => '',
                'mop_details' => ''
            ]
        );

        Payment::create(
            [
                'batch_id' => '4',
                'collector_id' => '4',
                'payment_sched' => Carbon::now()->format("Y-m-{$paymentDate}"),
                'payment_date' => Carbon::now()->subMonth(1)->subDays(2)->format('Y-m-d'),
                'days' => '0',
                'amount' => '100',
                'paid_amount' => '100',
                'balance' => '100',
                'mop' => '',
                'mop_details' => ''
            ]
        );


    }
}
