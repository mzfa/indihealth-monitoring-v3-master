<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskMaintenance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_maintenance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('task_maintenance_level_id');
            $table->string('task_name');
            $table->double('process',11,2);
            $table->double('timing',11,2);
            $table->datetime('start');
            $table->datetime('end');
            $table->string('kesulitan')->nullable();
            $table->string('solusi')->nullable();
            $table->boolean('is_done')->default(false);
            $table->timestamps();

            $table->softDeletes();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('task_maintenance_level_id')->references('id')->on('task_maintenance_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_maintenance');
    }
}
