<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collectors', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('fullname');
            $table->string('mobile');
            $table->string('address');
            $table->double('cashbond',8,2)->nullable();
            $table->string('ctc_no')->nullable();
            $table->string('status')->default('active');
            $table->string('row_status')->default('pending')->comment('approved, pending');
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
        Schema::dropIfExists('collectors');
    }
}
