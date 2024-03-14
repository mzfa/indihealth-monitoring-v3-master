<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('karyawan', function (Blueprint $table) {
           $table->string('github_link',200)->after('foto')->nullable();
           $table->string('bitbucket_link',200)->after('github_link')->nullable();
           $table->string('gitlab_link',200)->after('bitbucket_link')->nullable();
           $table->date('join_date')->after('gitlab_link')->nullable();
           $table->date('resign_date')->after('join_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn('github_link');
            $table->dropColumn('bitbucket_link');
            $table->dropColumn('gitlab_link');
            $table->dropColumn('join_date');
            $table->dropColumn('resign_date');
        });
    }
}
