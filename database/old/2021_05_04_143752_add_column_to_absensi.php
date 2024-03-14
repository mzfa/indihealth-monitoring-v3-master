<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToAbsensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('absensi', function (Blueprint $table) {
             $table->decimal('lng',12,8)->nullable()->after('foto');
             $table->decimal('lat',12,8)->nullable()->after('lng');
             $table->ipAddress('ip_address')->nullable()->after('jam_keluar');
             $table->string('browser',120)->nullable()->after('ip_address');
             $table->string('platform',120)->nullable()->after('browser');
             $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('absensi', function (Blueprint $table) {
             $table->dropColumn('lng');
             $table->dropColumn('lat');
             $table->dropColumn('ip_address');
             $table->dropColumn('user_agent');
             $table->dropColumn('updated_by');
        });
    }
}
