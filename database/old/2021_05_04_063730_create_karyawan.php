<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('nama_lengkap',80);
            $table->string('tempat_lahir',50);
            $table->date('tanggal_lahir');
            $table->string('no_telp');
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->string('foto');
            $table->bigInteger('updated_by',false)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('jabatan_id')->references('id')->on('jabatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('karyawan');
    }
}
