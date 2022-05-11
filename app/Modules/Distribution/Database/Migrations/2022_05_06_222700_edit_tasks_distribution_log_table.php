<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditTasksDistributionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tasks_distribution_log', 'before_member_capacity')) {
            Schema::table('tasks_distribution_log', function (Blueprint $table) {
                $table->integer('before_member_capacity')->after('shift_id')->nullable();
            });
        }

        if (!Schema::hasColumn('tasks_distribution_log', 'after_member_capacity')) {
            Schema::table('tasks_distribution_log', function (Blueprint $table) {
                $table->integer('after_member_capacity')->after('before_member_capacity')->nullable();
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
