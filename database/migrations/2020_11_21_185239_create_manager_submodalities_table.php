<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

class CreateManagerSubmodalitiesTable extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {

        Schema::create('manager_submodalities', function (Blueprint $table) {

           

            $table->unsignedInteger('manager_id');

            $table->char('sub_modalities_code',4);

            $table->foreign('manager_id')->references('id')->on('managers');

            $table->foreign('sub_modalities_code')->references('code')->on('sub_modalities');

        });

    }

    /**

     * Reverse the migrations.

     *

     * @return void

     */

    public function down()

    {

        Schema::dropIfExists('manager_submodalities');

    }

}