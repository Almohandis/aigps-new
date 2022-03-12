<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infections', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('hospital_id')->nullable()->default(null);
            $table->date('infection_date');
            $table->boolean('is_recovered')->default(false);
            $table->boolean('has_passed_away')->default(false);
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
        Schema::dropIfExists('infections');
    }
}
