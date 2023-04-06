<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('barcode')->nullable();
            $table->string('nik')->unique();
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('mobile_phone')->unique()->nullable();
            $table->bigInteger('organization_id');
            $table->bigInteger('location_id');
            $table->bigInteger('job_level_id');
            $table->bigInteger('division_id');
            $table->bigInteger('departement_id');
            $table->string('job_potition')->nullable();
            $table->date('join_date')->nullable();
            $table->date('resign_date')->nullable();
            $table->string('status_employee')->nullable();
            $table->date('end_date')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->longText('citizen_id_address')->nullable();
            $table->longText('resindtial_address')->nullable();
            $table->string('NPWP')->nullable()->unique();
            $table->string('PKTP_status')->nullable();
            $table->string('employee_tax_status')->nullable();
            $table->string('tax_config')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_account_holder')->nullable();
            $table->string('bpjs_ketenagakerjaan')->nullable();
            $table->string('bpjs_kesehatan')->nullable();
            $table->string('citizen_id')->nullable()->unique();
            $table->string('religion')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('nationality_code')->nullable();
            $table->string('currency')->nullable();
            $table->string('length_of_service')->nullable();
            $table->string('payment_schedule')->nullable();
            $table->bigInteger('approval_line')->nullable();
            $table->bigInteger('manager')->nullable();
            $table->integer('grade')->nullable();
            $table->integer('class')->nullable();
            $table->string('password');
            $table->bigInteger('schedule_id');
            $table->text('photo_path')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
