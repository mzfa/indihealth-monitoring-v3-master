<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruitments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruitments', function (Blueprint $table) {
            $table->id();
            $table->string('apply_id',120)->unique();//APP-2022-07-H0001
            $table->string('nama_lengkap',120);
            $table->text('alamat_lengkap');
            $table->date('tanggal_lahir',120);
            $table->string('email',80);
            $table->string('no_hp',30);
            $table->string('school',200);
            $table->string('pendidikan_terakhir',80);
            $table->string('jurusan',100);
            $table->string('minat',600);
            $table->string('tujuan_bergabung',500);
            $table->string('web_portofolio',200);
            $table->enum('employment_status',['Sedang-Bekerja','Tidak-Bekerja','Fresh-Graduate','Freelance']);
            $table->enum('position',['INTERN','REG']); // Internship //Regular
            $table->string('experience',200);
            $table->double('experience_level',3,2);//1-10
            $table->unsignedBigInteger('apply_position_id');
            $table->enum('founded_at',['Rekan','Web','Poster','Lainnya'])->nullable();
            $table->string('relation')->nullable();
            $table->string('ip_address',300)->nullable();
            $table->string('agent',1000)->nullable();
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
        Schema::dropIfExists('recruitments');
    }
}
