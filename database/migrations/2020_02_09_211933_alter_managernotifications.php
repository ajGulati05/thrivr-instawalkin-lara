<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterManagernotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('manager_notifications', function (Blueprint $table) {
                $table->boolean('email')->default(1);
                $table->boolean('text')->default(0);
                $table->boolean('desktop')->default(0)->change();
                $table->boolean('desktopsound')->default(0)->change();
                $table->boolean('web')->default(0)->change();
                $table->boolean('websound')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manager_notifications', function (Blueprint $table) {
               $table->dropColumn(['email','text']);
              $table->boolean('desktop')->default(1)->change();
                $table->boolean('desktopsound')->default(1)->change();
                $table->boolean('web')->default(1)->change();
                $table->boolean('websound')->default(1)->change();
        });
              
     
    }
}
