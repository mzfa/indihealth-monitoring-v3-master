<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSolusiDanKesulitanToTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
             $table->string('kesulitan')->after('process')->nullable();
             $table->string('solusi')->after('kesulitan')->nullable();
             $table->foreignId('project_id')->after('solusi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('kesulitan');
             $table->dropColumn('solusi');
             $table->dropColumn('project_id');
        });
    }
}
