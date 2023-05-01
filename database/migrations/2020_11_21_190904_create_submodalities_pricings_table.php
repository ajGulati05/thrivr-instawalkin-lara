<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

class CreateSubmodalitiesPricingsTable extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {

        Schema::create('submodalities_pricings', function (Blueprint $table) {

            $table->id();

            $table->char('sub_modalities_code',4);

            $table->decimal('price', 8, 2);

            $table->date('expired_on')->nullable();

            $table->char('province',3)->default('SK');

            $table->foreign('sub_modalities_code')->references('code')->on('sub_modalities');

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

        Schema::dropIfExists('submodalities_pricings');

    }

}