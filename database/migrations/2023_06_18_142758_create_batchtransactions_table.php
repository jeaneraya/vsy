<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchtransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batchtransactions', function (Blueprint $table) {
            $table->id();
            $table->integer('num');
            $table->date('period_from');
            $table->date('period_to');
            $table->integer('collector_id');
            $table->string('remarks')->nullable();
            $table->date('first_collection');
            $table->double('addon_interest')->nullable();
            $table->string('status')->default('1');
            $table->double('offset_balance')->nullable();
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
        Schema::dropIfExists('batchtransactions');
    }
}
