<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamMembersShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_members_shifts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shift_id')->unsigned();
            $table->bigInteger('team_member_id')->unsigned();

            $table->foreign('shift_id')->references('id')->on('shifts')
                ->onDelete('cascade');

            $table->foreign('team_member_id')->references('id')->on('team_members')
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
        Schema::dropIfExists('team_members_shifts');
    }
}
