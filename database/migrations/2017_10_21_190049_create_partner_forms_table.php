<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartnerFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partner_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->text('businessname');
            $table->text('contactname');
            $table->text('contactphone');
            $table->text('contactemail');
            $table->text('city');
            $table->boolean('acknowledged')->default(0);
            $table->boolean('contacted')->default(0);
            $table->boolean('partner')->default(0);
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
        Schema::dropIfExists('partner_forms');
    }
}
