<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstaPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instaprices', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('price',5,2);
            $table->unsignedInteger('servicecategories_id');
            $table->foreign('servicecategories_id')->references('id')->on('servicecategories');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('instaprices');
    }
}
