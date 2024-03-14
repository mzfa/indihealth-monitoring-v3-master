<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTaskDevelopmentPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('tasks', function (Blueprint $table) {
           $table->unsignedBigInteger('task_plan_id')->nullable()->after('karyawan_id');
            $table->foreign('task_plan_id')->references('id')->on('task_plans');
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
           $table->dropColumn('task_plan_id');
      });
    }
}
