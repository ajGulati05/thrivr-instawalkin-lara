<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableManagerProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manager_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('manager_id');
            $table->string('address');
            $table->string('phone');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('code'); //B for business and M for mailing address
            $table->timestamps();
            $table->foreign('manager_id')->references('id')->on('managers');
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('manager_profiles');

    }
}
