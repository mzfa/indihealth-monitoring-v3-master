<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nama_perusahaan');
            $table->string('no_telp')->nullable();
            $table->string('jabatan');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('activated_at')->nullable();
            $table->string('password');
            $table->boolean('is_banned')->default(0);
            $table->timestamps();
            $table->bigInteger('updated_by',false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guests');
    }
}
