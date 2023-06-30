<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemindersLoggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminders_loggers', function (Blueprint $table) {
            $table->id();
            $table->integer('reminder_id')->nullable()->comment('null = automated');
            $table->datetime('sent_datetime')->nullable();
            $table->string('description')->nullable();
            $table->integer('type')->default(1)->comment('reminder_types table');
            $table->integer('sent_to')->default(0)->comment('user_id or 0 system');
            $table->string('message')->nullable()->comment('user_id or 0 system');
            $table->integer('sent_via')->default(1)->comment('1 - sms, 2 - noticification');
            $table->date('schedule')->nullable();
            $table->integer('is_read')->default(0)->comment('0 - no, 1 - yes');
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
        Schema::dropIfExists('reminders_loggers');
    }
}
