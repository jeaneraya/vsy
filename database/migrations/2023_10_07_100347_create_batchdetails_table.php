<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batchdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('delivery_id');
            $table->integer('batch_id');
            $table->date('date_delivered')->nullable();
            $table->string('ref_no')->nullable();
            $table->integer('product_id');
            $table->integer('qty');
            $table->double('total_amount');
            $table->integer('return_qty')->nullable();
            $table->date('date_returned')->nullable();
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
        Schema::dropIfExists('batchdetails');
    }
}
