<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_lists', function (Blueprint $table) {
            $table->id();
            $table->string("code")->unique();//IDH-(DEV/MRT/ADM)-0001
            $table->enum("departement",['Software Developer','Marketing','Administration'])->unique();
            $table->string('name',120);
            $table->text('description');
            $table->string('file',120)->nullable();
            $table->datetime('expired')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_list');
    }
}
