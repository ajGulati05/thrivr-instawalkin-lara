<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterImageSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('managers', function (Blueprint $table) {
               $table->text('mini_avatar')->nullable();
               $table->json('mini_avatar_attributes')->nullable();
               $table->json('avatar_attributes')->nullable();
              
                
        });

        Schema::table('manager_specialities', function (Blueprint $table) {
               $table->json('speciality_photo_attribute')->nullable();

              
                
        });

         Schema::table('userprofiles', function (Blueprint $table) {
               $table->json('avatar_attributes')->nullable();
              
                
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
               $table->dropColumn(['mini_avatar','mini_avatar_attributes','avatar_attributes']);
               
                
        });

           Schema::table('manager_specialities', function (Blueprint $table) {
               $table->dropColumn('speciality_photo_attribute');

              
                
        });

            Schema::table('userprofiles', function (Blueprint $table) {
               $table->dropColumn('avatar_attributes');
              
                
        });
    }
}
