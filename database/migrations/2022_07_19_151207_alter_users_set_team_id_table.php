<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersSetTeamIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('users', 'managed_team_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->bigInteger('managed_team_id')->unsigned()->after('password')->nullable();
                $table->foreign('managed_team_id')->references('id')->on('teams')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
