<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksDistributionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks_distribution_log', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_created_on_jira')->default(true);

            $table->bigInteger('team_id')->unsigned();
            $table->bigInteger('team_member_id')->unsigned();
            $table->bigInteger('task_id')->unsigned();
            $table->bigInteger('shift_id')->unsigned()->nullable()->default(null);

            $table->foreign('team_id')->references('id')->on('teams')
                ->onDelete('cascade');

            $table->foreign('team_member_id')->references('id')->on('team_members')
                ->onDelete('cascade');

            $table->foreign('task_id')->references('id')->on('tasks')
                ->onDelete('cascade');

            $table->foreign('shift_id')->references('id')->on('shifts')
                ->onDelete('cascade');

            $table->string('task_type')->nullable();
            $table->integer('before_member_capacity')->nullable();
            $table->integer('after_member_capacity')->nullable();

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
        Schema::dropIfExists('tasks_distribution_log');
    }
}
