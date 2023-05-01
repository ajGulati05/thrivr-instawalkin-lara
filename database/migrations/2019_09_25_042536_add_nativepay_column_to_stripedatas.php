<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNativepayColumnToStripedatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stripedatas', function (Blueprint $table) {
            //
             $table->boolean("native_pay")->default('0');  //this will be used to tell if the card is on apple pay or google pay
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stripedatas', function (Blueprint $table) {
             $table->dropColumn('native_pay');
        });
    }
}
