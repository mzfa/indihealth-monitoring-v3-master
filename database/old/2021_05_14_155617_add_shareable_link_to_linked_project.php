<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShareableLinkToLinkedProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linked_project_guests', function (Blueprint $table) {
           $table->string('shareable_link',90)->after('project_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('linked_project_guests', function (Blueprint $table) {
             $table->dropColumn('shareable_link');
       
        });
    }
}
