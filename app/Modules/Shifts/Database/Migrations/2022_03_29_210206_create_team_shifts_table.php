<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_shifts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shift_id')->unsigned();
            $table->bigInteger('team_id')->unsigned();

            $table->foreign('shift_id')->references('id')->on('shifts')
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
        Schema::dropIfExists('team_shifts');
    }
}
