<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTaskDistrubtionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('tasks_distribution_log', 'shift_id')) {
            Schema::table('tasks_distribution_log', function (Blueprint $table) {
                $table->dropColumn('shift_id');
            });
        }

        if (! Schema::hasColumn('tasks_distribution_log', 'schedule_id')) {
            Schema::table('tasks_distribution_log', function (Blueprint $table) {
                $table->bigInteger('schedule_id')->after('task_id')->unsigned()->nullable()->default(null);

                $table->foreign('schedule_id')->references('id')->on('member_schedules')
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
