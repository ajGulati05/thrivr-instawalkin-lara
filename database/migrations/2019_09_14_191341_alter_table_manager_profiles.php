<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableManagerProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('manager_profiles', function (Blueprint $table) {
               $table->string('tag_line')->nullable();
               $table->boolean('parking')->default(0);
                
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
               $table->dropColumn(['tag_line','parking']);
              
        });
    }
}
