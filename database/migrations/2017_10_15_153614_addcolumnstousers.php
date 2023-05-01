<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Addcolumnstousers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::table('users', function (Blueprint $table) {
            $table->boolean('agree')->default(0)->after('password');
            $table->boolean('emailsent')->default(0)->after('agree');
            $table->boolean('confirmed')->default(1)->after('emailsent');
            
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
