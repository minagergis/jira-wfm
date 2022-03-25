<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamMembersTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_members_team', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('team_member_id')->unsigned();
            $table->bigInteger('team_id')->unsigned();

            $table->foreign('team_member_id')->references('id')->on('team_members')
                ->onDelete('cascade');

            $table->foreign('team_id')->references('id')->on('teams')
                ->onDelete('cascade');

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
        Schema::dropIfExists('team_members_team');
    }
}
