<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('trans_date');
            $table->integer('client_id');
            $table->string('ref_no')->nullable();
            $table->string('trans_description');
            $table->double('payments')->nullable();
            $table->double('charges')->nullable();
            $table->string('or_num_charges')->nullable();
            $table->double('balance')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('clients_transactions');
    }
}
