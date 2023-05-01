<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFutureemailReminderColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('guests', function (Blueprint $table) {
            $table->boolean('future_reminder')->default(1);
        });   

         Schema::table('user_notifications', function (Blueprint $table) {
            $table->boolean('future_reminder')->default(1);
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
            $table->dropColumn('future_reminder');
        });   

         Schema::table('user_notifications', function (Blueprint $table) {
            $table->dropColumn('future_reminder');
        });   
    }
}
