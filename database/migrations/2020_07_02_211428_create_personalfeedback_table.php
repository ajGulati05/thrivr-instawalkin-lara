<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalfeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('review_id');
            $table->text('user_comment');
            $table->text('manager_reply');
            $table->foreign('review_id')->references('id')->on('reviews');
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
        Schema::dropIfExists('personal_feedbacks');
    }
}
