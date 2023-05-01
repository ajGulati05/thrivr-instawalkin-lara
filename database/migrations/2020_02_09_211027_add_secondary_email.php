<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSecondaryEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
    {
        Schema::create('secondary_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->timestamps();
        });

          Schema::create('manager_secondary_email', function (Blueprint $table) {

            $table->integer('secondary_emails_id')->unsigned();
            $table->integer('manager_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('secondary_emails');
        Schema::dropIfExists('secondary_email_manager');
    }
}
