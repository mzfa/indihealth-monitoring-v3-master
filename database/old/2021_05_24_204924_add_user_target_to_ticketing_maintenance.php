<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserTargetToTicketingMaintenance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticketing_maintenance', function (Blueprint $table) {
            $table->unsignedBigInteger('target_user')->nullable()->after('target_ticketing');
            $table->foreign('target_user')->references('id')->on('users');
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
            \DB::statement("ALTER TABLE ticketing_maintenance DROP FOREIGN KEY ticketing_maintenance_target_user_foreign");
            Schema::table('ticketing_maintenance', function (Blueprint $table) {
               $table->dropColumn('target_user');
            });
            Schema::enableForeignKeyConstraints();
    }
}
