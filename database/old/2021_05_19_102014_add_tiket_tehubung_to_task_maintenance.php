<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTiketTehubungToTaskMaintenance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_maintenance', function (Blueprint $table) {
            $table->unsignedBigInteger('ticketing_id')->after('task_maintenance_level_id');

            $table->foreign('ticketing_id')->references('id')->on('ticketing_maintenance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::disableForeignKeyConstraints();
        \DB::statement("ALTER TABLE task_maintenance DROP FOREIGN KEY task_maintenance_ticketing_id_foreign");
        Schema::table('task_maintenance', function (Blueprint $table) {
           $table->dropColumn('ticketing_id');
        });
        Schema::enableForeignKeyConstraints();
    }
}
