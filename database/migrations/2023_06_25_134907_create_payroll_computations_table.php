<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollComputationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_computations', function (Blueprint $table) {
            $table->id();
            $table->integer('payroll_schedule_id');
            $table->integer('employee_id');

            $table->integer('rate_per_day')->default(0);
            $table->integer('hours_overtime')->default(0);
            $table->integer('hours_late')->default(0);
            $table->integer('days_absent')->default(0);
            $table->integer('days_present')->default(0);
            $table->float('sss')->default(0);
            $table->float('pagibig')->default(0);
            $table->float('philhealth')->default(0);
            $table->float('others')->default(0);

            $table->double('bonus')->default(0);
            $table->double('total_deductions')->default(0);
            $table->double('gross_pay')->default(0);
            $table->double('net_pay')->default(0);

            $table->integer('status')->default(0)->comment('0 - pending, 1 - done');
            $table->integer('is_claimed')->default(0)->comment('0 - no, 1 - yes');
            $table->date('date_claimed')->nullable();
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
        Schema::dropIfExists('payroll_computations');
    }
}
