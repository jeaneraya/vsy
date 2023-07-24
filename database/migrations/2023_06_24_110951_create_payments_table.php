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
            $table->date('payment_sched');
            $table->date('payment_date')->nullable();
            $table->integer('days')->nullable();
            $table->double('amount')->default(0);
            $table->double('paid_amount')->default(0);
            $table->double('balance')->default(0);
            $table->string('mop')->nullable();
            $table->string('mop_details')->nullable();
            $table->string('payment_status')->default('unpaid');
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
