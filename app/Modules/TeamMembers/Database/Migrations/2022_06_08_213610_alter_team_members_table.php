<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('team_members', 'is_in_shift_now')) {
            Schema::table('team_members', function (Blueprint $table) {
                $table->dropColumn('is_in_shift_now');
            });
        }

        if (! Schema::hasColumn('team_members', 'color')) {
            Schema::table('team_members', function (Blueprint $table) {
                $table->string('color')->after('weight')->nullable()->default(null);
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
