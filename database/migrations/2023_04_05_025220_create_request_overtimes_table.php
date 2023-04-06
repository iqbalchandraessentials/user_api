<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_overtimes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('timeoff_id');
            $table->string('start_date');
            $table->string('end_date');
            $table->longText('description')->nullable();
            $table->bigInteger('delegation_id')->nullable();
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
        Schema::dropIfExists('request_overtimes');
    }
}
