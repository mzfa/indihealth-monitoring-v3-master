<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationToTicketingMaintenance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticketing_maintenance', function (Blueprint $table) {
            $table->foreign('target_ticketing')->references('id')->on('target_ticketing_divisions');
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
            \DB::statement("ALTER TABLE ticketing_maintenance DROP FOREIGN KEY ticketing_maintenance_target_ticketing_foreign");
            Schema::table('ticketing_maintenance', function (Blueprint $table) {
               $table->dropColumn('target_ticketing');
               $table->unsignedBigInteger('target_ticketing')->after('guest_id');
            });
            Schema::enableForeignKeyConstraints();
    }
}
