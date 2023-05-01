<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSpecialityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manager_specialities', function (Blueprint $table) {
      
            $table->string('long_description')->default('Needs Value');
        

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manager_specialities', function (Blueprint $table) {
      
            $table->dropColumn('long_description');
        

        });
    }
}
