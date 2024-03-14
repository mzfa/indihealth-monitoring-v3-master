<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsReadToTaskMaintenanceMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_maintenance_members', function (Blueprint $table) {
            $table->boolean('is_read_toast')->after('task_maintenance_id')->default(0);
            $table->boolean('is_read_notif')->after('is_read_toast')->default(0);

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
            $table->dropColumn('is_read');
            $table->dropColumn('is_read_notif');
        });
    }
}
