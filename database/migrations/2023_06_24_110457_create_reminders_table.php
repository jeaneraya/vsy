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
            $table->datetime('schedule');
            $table->integer('template_id')->default(0);
            $table->integer('type')->default(1)->comment('1 - custom, 2 - template, 3 - birthday, 4 - renewal, 5 - registration, 6 - insurance');
            $table->integer('status')->default(0)->comment('0 - pending, 1 - sent, 2 - failed, 3 - cancelled');
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
