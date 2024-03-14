<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAbsenKeluarCollumnToAbsensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('absensi', function (Blueprint $table) {
             $table->string('foto_pulang',255)->nullable()->after('foto');
             $table->decimal('lng_pulang',12,8)->nullable()->after('lat');
             $table->decimal('lat_pulang',12,8)->nullable()->after('lng_pulang');
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
             $table->dropColumn('foto_pulang');
             $table->dropColumn('lng_pulang');
             $table->dropColumn('lat_pulang');
        });
    }
}
