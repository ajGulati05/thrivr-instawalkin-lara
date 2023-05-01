<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

class CreateSubModalitiesTable extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {

        Schema::create('sub_modalities', function (Blueprint $table) {

            $table->char('code',4)->unique();

            $table->text('description');

            $table->boolean('active')->default(1);

            $table->boolean('only_admin_panel')->default(0);

            $table->string('minutes')->nullable();

            $table->timestamps();

            $table->primary('code');

        });

    }

    /**

     * Reverse the migrations.

     *

     * @return void

     */

    public function down()

    {

        Schema::dropIfExists('sub_modalities');

    }

}