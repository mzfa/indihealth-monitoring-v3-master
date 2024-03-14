<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectTeamMember extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::create('project_team_members', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('user_id');
          $table->unsignedBigInteger('project_id');
          $table->unsignedBigInteger('project_team_id');
          $table->boolean('is_pm')->default(false);
          $table->string('keterangan',160)->nullable();
          $table->timestamps();
          $table->bigInteger('updated_by',false);
          $table->softDeletes();
          $table->foreign('user_id')->references('id')->on('users');
          $table->foreign('project_id')->references('id')->on('projects');
          $table->foreign('project_team_id')->references('id')->on('project_teams');
      });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
      Schema::dropIfExists('project_teams');
  }
}
