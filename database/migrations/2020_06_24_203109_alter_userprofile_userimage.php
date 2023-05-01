<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserprofileUserimage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('userprofiles', function (Blueprint $table) {
               $table->string('avatar')->nullable();
               $table->text('phone')->nullable()->change();
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('userprofiles', function (Blueprint $table) {
               $table->dropColumn('avatar');
                $table->text('phone')->change();      
        });
    }
}
