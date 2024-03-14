<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaskIndividualToTaskMaintenanceMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_maintenance_members', function (Blueprint $table) {
            $table->string('tugas_individu',300)->nullable()->after('task_maintenance_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_maintenance_members', function (Blueprint $table) {
            $table->dropColumn('tugas_individu');
        });
    }
}
