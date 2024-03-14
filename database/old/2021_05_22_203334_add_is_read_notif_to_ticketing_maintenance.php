<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsReadNotifToTicketingMaintenance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticketing_maintenance', function (Blueprint $table) {
            $table->string('alamat_situs',350)->nullable()->after('title');
            $table->boolean('is_read_notif')->default(false)->after('status');
            $table->boolean('is_read_toast')->default(false)->after('is_read_notif');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticketing_maintenance', function (Blueprint $table) {
          $table->dropColumn('alamat_situs');
          $table->dropColumn('is_read_notif');
          $table->dropColumn('is_read_toast');
        });
    }
}
