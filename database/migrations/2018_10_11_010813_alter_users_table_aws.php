<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableAws extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
              Schema::table('users', function (Blueprint $table) {
               $table->string('arn')->nullable();
               $table->string('platform')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
