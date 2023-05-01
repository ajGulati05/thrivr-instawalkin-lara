<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntakeFormsManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intake_forms_manager', function (Blueprint $table) {

            $table->uuid('intakeform_id');
            $table->unsignedInteger('manager_id');
            $table->boolean('active')->default(1);
            $table->timestamps();
            $table->foreign('manager_id')->references('id')->on('managers');
            $table->foreign('intakeform_id')->references('id')->on('intake_forms');
            $table->primary(['manager_id','intakeform_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intake_forms_manager');
    }
}
