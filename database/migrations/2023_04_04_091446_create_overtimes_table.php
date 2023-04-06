<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('schedule_id');
            $table->string('selected_date');
            $table->string('overtime_duration_before')->nullable();
            $table->string('overtime_duration_after')->nullable();
            $table->string('description')->nullable();
            $table->string('upload_file')->nullable();
            $table->boolean('approve')->default('0');
            $table->bigInteger('approve_by');
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
        Schema::dropIfExists('overtimes');
    }
}
