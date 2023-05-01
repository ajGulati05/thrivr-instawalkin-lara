<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGuestsTableToTempUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('guests', function (Blueprint $table) {
               $table->unsignedInteger('user_id')->nullable();
               $table->boolean('user_exists')->default(0); /// this just says the user exissts
               $table->boolean('migrated')->default(0);
               $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('guests', function (Blueprint $table) {
               $table->dropColumn(['user_id','user_exists','migrated']);

        });
    }
}
