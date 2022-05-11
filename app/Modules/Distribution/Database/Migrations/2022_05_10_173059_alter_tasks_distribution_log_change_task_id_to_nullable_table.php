<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTasksDistributionLogChangeTaskIdToNullableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('tasks_distribution_log', 'task_id')) {
            Schema::table('tasks_distribution_log', function (Blueprint $table) {
                $table->bigInteger('task_id')->unsigned()->nullable()->change();
            });
        }

        if (! Schema::hasColumn('tasks_distribution_log', 'jira_issue_key')) {
            Schema::table('tasks_distribution_log', function (Blueprint $table) {
                $table->string('jira_issue_key')->after('shift_id')->nullable();
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
