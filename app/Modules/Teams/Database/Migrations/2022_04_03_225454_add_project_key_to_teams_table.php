<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProjectKeyToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('teams', 'jira_project_key')) {
            Schema::table('teams', function (Blueprint $table) {
                $table->string('jira_project_key')->nullable()->after('description');
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
        if (Schema::hasColumn('teams', 'jira_project_key')) {
            Schema::table('teams', function (Blueprint $table) {
                $table->dropColumn('jira_project_key');
            });
        }
    }
}
