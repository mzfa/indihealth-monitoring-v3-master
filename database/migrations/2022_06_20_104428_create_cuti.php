<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuti', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('karyawan_id');
            $table->date('start');
            $table->date('end');
            $table->unsignedInteger('jumlah');
            $table->text('reason_cuti')->nullable();
            $table->unsignedBigInteger('status_by')->nullable();

            $table->boolean('status')->nullable(); //0 reject 1 approve 2 reject

            $table->text('reason_status')->nullable();
            $table->boolean('is_read')->default(0); 
            $table->boolean('is_toast')->default(0);             
            $table->timestamps();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('karyawan_id')->references('id')->on('karyawan');
            $table->foreign('status_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuti');
    }
}
