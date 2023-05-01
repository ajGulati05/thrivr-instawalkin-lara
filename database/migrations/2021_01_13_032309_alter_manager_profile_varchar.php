<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterManagerProfileVarchar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::table('manager_profiles', function (Blueprint $table) {
             $table->string('about',2500)->nullable()->change();
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('manager_profiles', function (Blueprint $table) {
               $table->string('about',2500)->nullable()->change();
                
        });
    }
}
