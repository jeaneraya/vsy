<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAplistTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aplist_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('ap_id');
            $table->date('schedule_date');
            $table->double('amount_payable')->default(0);
            $table->double('amount_paid')->default(0);
            $table->string('remarks')->nullable();
            $table->double('balance')->default(0);
            $table->integer('post_status')->default(0);//0=unposted, 1=posted
            $table->string('type')->nullable();
            $table->string('bank')->nullable();
            $table->string('check_num')->nullable();
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
        Schema::dropIfExists('aplist_transactions');
    }
}
