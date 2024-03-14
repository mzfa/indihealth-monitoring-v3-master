<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTaskPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_plan_details', function (Blueprint $table) {
          $table->id();
          $table->string('name',80);
          $table->unsignedBigInteger('task_plan_id')->nullable();
          $table->string('description',220)->nullable();
          $table->date('start_date');
          $table->date('end_date');
          $table->timestamps();
          $table->unsignedBigInteger('updated_by')->nullable();
          $table->softDeletes();


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
        Schema::dropIfExists('task_plan_details');
    }
}
