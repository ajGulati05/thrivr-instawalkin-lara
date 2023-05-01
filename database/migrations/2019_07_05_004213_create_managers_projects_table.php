<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagersProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('managers_projects')) {
            Schema::create('managers_projects', function (Blueprint $table) {
               // $table->increments('id');
                $table->unsignedInteger('manager_id');
                $table->unsignedInteger('project_id'); //this is not being used anymore
              //  $table->primary(['project_id', 'manager_id','id']);
                $table->foreign('project_id')->references('id')->on('projects');
                $table->foreign('manager_id')->references('id')->on('managers');

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('managers_projects');
    }
}
