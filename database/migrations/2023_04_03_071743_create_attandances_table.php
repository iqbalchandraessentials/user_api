<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttandancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attandances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->dateTime('check_in');
            $table->string('img_check_in');
            $table->string('longitude_in');
            $table->string('latitude_in');
            $table->longText('description_in')->nullable();
            $table->boolean('live_absen_in')->default('0');
            $table->boolean('approval_in')->default('0');
            $table->dateTime('check_out')->nullable();
            $table->string('img_check_out')->nullable();
            $table->string('longitude_out')->nullable();
            $table->string('latitude_out')->nullable();
            $table->longText('description_out')->nullable();
            $table->boolean('live_absen_out')->default('0');
            $table->boolean('approval_out')->default('0');
            $table->bigInteger('approve_by');
            $table->string('overtime_before')->nullable();
            $table->string('status')->default('H');
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
        Schema::dropIfExists('attandances');
    }
}
