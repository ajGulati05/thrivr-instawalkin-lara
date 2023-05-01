<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableManagerEndorsements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endorsement_review', function (Blueprint $table) {
           
            $table->foreignId('endorsement_id');
            $table->unsignedInteger('review_id');
            $table->foreign('endorsement_id')->references('id')->on('endorsements');
            $table->foreign('review_id')->references('id')->on('reviews');
            $table->primary(['endorsement_id', 'review_id']);
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('endorsement_review');
    }
}
