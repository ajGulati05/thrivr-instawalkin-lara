<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAddFlagForFirstLook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('managers', function (Blueprint $table) {
            $table->boolean('first_login')->default(0);
});
           Schema::table('manager_profiles', function (Blueprint $table) {
                    $table->dropColumn('code');
            
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('managers', function (Blueprint $table) {
            $table->dropColumn('first_login');
       
        });
    }
}
