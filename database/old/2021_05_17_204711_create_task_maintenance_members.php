<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskMaintenanceMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_maintenance_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('task_maintenance_id');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->softDeletes();


            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('task_maintenance_id')->references('id')->on('task_maintenance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_maintenance_members');
    }
}
