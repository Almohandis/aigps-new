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
            $table->biginteger('national_id')->unique();
            $table->date('birthdate')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->string('telephone_number')->nullable()->default(null);
            $table->string('gender')->nullable()->default(null);
            $table->integer('role_id')->default(0);
            $table->char('blood_type', 3)->nullable()->default(null);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('hospital_id');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
