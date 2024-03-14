<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketingMaintenance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticketing_maintenance', function (Blueprint $table) {
            $table->id();
            $table->string('no_ticket',18)->unique();//MT-2021010200001
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('guest_id');
            $table->unsignedBigInteger('target_ticketing');
            $table->string('title',200);
            $table->text('kronologi');
            $table->string('screenshot', 120)->nullable();
            $table->enum('status',['PENDING','UNDER-INVESTIGATION','FIXING','DONE'])->default('PENDING');

            $table->timestamps();

            $table->softDeletes();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('guest_id')->references('id')->on('guests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticketing_maintenance');
    }
}
