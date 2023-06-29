<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('batch_id');
            $table->integer('collector_id');
            $table->date('payment_sched')->nullable();
            $table->date('payment_date');
            $table->integer('days');
            $table->double('amount')->nullable();
            $table->double('paid_amount');
            $table->double('balance');
            $table->string('mop');
            $table->string('mop_details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
