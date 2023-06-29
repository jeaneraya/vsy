<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->date('schedule');
            $table->integer('template_id')->default(0);
            $table->integer('type')->default(1)->comment('1 - custom, 2 - template, 3 - birthday, 4 - renewal, 5 - registration, 6 - insurance');
            $table->integer('recipient')->default(0)->comment('0 - to system, not 0 - users.id');
            $table->string('message')->nullable();
            $table->integer('frequency')->default(1)->comment('1 - One time, 2 - Daily, 3 - Weekly, 4 - Monthly, 5 - Yearly');
            $table->integer('status')->default(0)->comment('0 - pending, 1 - sent, 2 - failed, 3 - cancelled');
            $table->integer('is_active')->default(1)->comment('1 - active, 2 - inactive');
            $table->integer('created_by')->comment('users.id');
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
        Schema::dropIfExists('reminders');
    }
}
