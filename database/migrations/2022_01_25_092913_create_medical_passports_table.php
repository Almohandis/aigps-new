<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalPassportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_passports', function (Blueprint $table) {
            $table->id();
            $table->string('passport_number')->unique()->nullable()->default(null);
            $table->integer('user_id');
            $table->string('vaccine_name')->nullable()->default(null);
            $table->integer('vaccine_dose_count')->nullable()->default(0);
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
        Schema::dropIfExists('medical_passports');
    }
}
