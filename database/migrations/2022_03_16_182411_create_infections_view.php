<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateInfectionsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE VIEW IF NOT EXISTS infections_id AS
        SELECT DISTINCT u1.id FROM users AS u1, infections AS inf1 WHERE inf1.user_id=u1.id AND inf1.has_passed_away=0 AND inf1.is_recovered=0');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS infections_id');
    }
}
