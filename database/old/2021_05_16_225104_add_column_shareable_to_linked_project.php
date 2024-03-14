<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnShareableToLinkedProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('linked_project_guests', function (Blueprint $table) {
           $table->boolean('shareable_task_dev')->after('project_id')->default(0);
           $table->boolean('shareable_task_mt')->after('shareable_task_dev')->default(0);
           $table->boolean('shareable_notulen')->after('shareable_task_mt')->default(0);
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
           $table->dropColumn('shareable_task_dev');
           $table->dropColumn('shareable_task_mt');
           $table->dropColumn('shareable_notulen');
        });
    }
}
