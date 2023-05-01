<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Going to add phone nullable, make email nullable
        Schema::table('guests', function (Blueprint $table) {
                $table->string('email')->nullable()->change();
                $table->text('phone')->nullable();
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

        Schema::table('guests', function (Blueprint $table) {
               $table->dropColumn(['phone']);
                $table->string('email')->change();
              
        });
    }
}
