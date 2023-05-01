<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GenderEmployeeAlter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
             Schema::table('genders', function (Blueprint $table) {
               
                $table->string('code')->nullable();
                
        });
            Schema::table('employees', function (Blueprint $table) {
                $table->string('gender_id')->nullable()->change();
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
