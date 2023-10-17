<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_deliveries', function (Blueprint $table) {
            $table->id();
            $table->integer('batch_id')->nullable();
            $table->integer('collector_id')->nullable();
            $table->string('dr_num')->nullable();
            $table->date('date_withdrawn')->nullable();
            $table->string('remarks')->nullable();
            $table->double('amount')->nullable();
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
        Schema::dropIfExists('batch_deliveries');
    }
}
