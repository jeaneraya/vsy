<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockdeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stockdeliveries', function (Blueprint $table) {
            $table->id();
            $table->date('covered_date')->nullable();
            $table->integer('am_id');
            $table->string('description');
            $table->string('dr_num')->nullable();;
            $table->double('total_delivery')->nullable();;
            $table->double('amount_paid')->nullable();;
            $table->double('balance');
            $table->date('cutoff_date')->nullable();
            $table->double('credit_limit')->nullable();
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
        Schema::dropIfExists('stockdeliveries');
    }
}
