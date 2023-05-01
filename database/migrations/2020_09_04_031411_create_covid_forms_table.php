<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCovidFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid_forms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->morphs('covidformable');
            $table->unsignedBigInteger('userguest_id')->nullable();
            $table->boolean('active');
            $table->text('name');
            $table->text('testing');
            /*
                Covid Y/No if Yes when 
                Antibody: Y/N 
                What were the results
            */

            $table->text('symptoms');
/*
Fever, Fatigue,Chills,Cough,Sore Throat, Shortness of breath, Suddent Onset, Suddent Loss of taste smell, body aches

;*/

$table->text('exposure');
$table->text('travel');
$table->text('precautions')->nullable();
$table->text('contact');
$table->text('actions');
$table->text('consent');
$table->timestamps();
$table->foreign('userguest_id')->references('id')->on('user_guests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('covid_forms');
    }
}
