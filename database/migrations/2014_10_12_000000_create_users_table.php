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
            $table->integer('role_id')->default(3);
            $table->string('country')->nullable()->default(null);
            $table->string('city')->nullable()->default(NULL);
            $table->char('blood_type', 3)->nullable()->default(null);
            $table->string('email')->unique();
            $table->integer('hospital_id')->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_diagnosed')->default(false);
            $table->string('password');
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
