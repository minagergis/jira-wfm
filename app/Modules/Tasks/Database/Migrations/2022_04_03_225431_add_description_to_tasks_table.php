<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tasks', 'description')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->string('description')->nullable()->after('points');
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
        if (Schema::hasColumn('tasks', 'description')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
}
