<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('effective_date');
            $table->boolean('override_national_holiday')->default('0');
            $table->boolean('override_company_holiday')->default('0');
            $table->boolean('flexible')->default('0');
            $table->boolean('include_late')->default('0');
            $table->bigInteger('shift_id');
            $table->boolean('initial_shift')->default('0');
            $table->boolean('active')->default('0');
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
        Schema::dropIfExists('schedules');
    }
}
