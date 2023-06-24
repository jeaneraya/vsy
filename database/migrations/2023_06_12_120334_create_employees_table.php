<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('employee_code')->nullable();
            $table->date('birthday');
            $table->string('address');
            $table->string('contact');
            $table->date('date_hired')->nullable();
            $table->date('date_resigned')->nullable();
            $table->string('hiring_status')->default(0)->comment('0 - active, 1 - resigned');
            $table->string('position');
            $table->double('rate_per_day',8,2)->default(0);
            $table->double('overtime_pay',8,2)->default(0);
            $table->double('interest',8,2)->default(0);
            $table->string('ctc_number')->nullable;
            $table->string('place_issued')->nullable();
            $table->string('date_issued')->nullable();
            $table->string('status')->comment('0 - n/a, 1 - contractual, 2 - Floating, 3 - OJT, 4 - Regular, 5 - Temporary');
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
