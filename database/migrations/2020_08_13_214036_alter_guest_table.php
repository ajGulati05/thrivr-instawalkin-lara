<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGuestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('guests', function (Blueprint $table) {
            $table->renameColumn('first_name','firstname');
         $table->renameColumn('last_name','lastname');
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
            $table->renameColumn('firstname','first_name');
         $table->renameColumn('lastname','last_name');
        }); 
    }
}
