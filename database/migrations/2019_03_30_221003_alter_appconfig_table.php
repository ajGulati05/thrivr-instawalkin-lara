<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAppconfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         

          Schema::table('appconfigs', function (Blueprint $table) {
               $table->string('stringvalue')->nullable();
               $table->integer('value')->nullable()->change();
                
        });

           Schema::table('transactions', function (Blueprint $table) {
            $table->text("newname")->nullable();
            $table->text("newaddress")->nullable();
            $table->text("newpostalcode")->nullable();
            $table->text("newlat")->nullable();
            $table->text("newlong")->nullable();
            $table->text("newcity")->nullable();
            $table->text("newprovince")->nullable();
             $table->text("newdescription")->nullable();  
        });

             Schema::table('locations', function (Blueprint $table) {
                $table->text("description")->nullable();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
           Schema::table('appconfigs', function (Blueprint $table) {
               $table->integer('value')->change();
               $table->dropColumn('stringvalue');
              
        });

           Schema::table('transactions', function (Blueprint $table) {
             $table->dropColumn("newname");
            $table->dropColumn("newaddress");
            $table->dropColumn("newpostalcode");
            $table->dropColumn("newlat");
            $table->dropColumn("newlong");
            $table->dropColumn("newcity");
            $table->dropColumn("newprovince");
             $table->dropColumn("newdescription");  
        });

             Schema::table('locations', function (Blueprint $table) {
                $table->dropColumn("description");  
        });
    }
}
