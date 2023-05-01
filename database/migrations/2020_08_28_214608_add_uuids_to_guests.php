<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUuidsToGuests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guests', function (Blueprint $table) {
           $table->uuid('instauuid')->nullable()->unique();
        });
         Schema::table('user_guests', function (Blueprint $table) {
           $table->uuid('instauuid')->nullable()->unique();
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
            $table->dropColumn(['instauuid']);
        });
         Schema::table('user_guests', function (Blueprint $table) {
            $table->dropColumn(['instauuid']);
        });
    }
}
