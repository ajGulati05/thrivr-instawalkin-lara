<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddS3bucketUrlToSpecialitiesManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('manager_specialities', function (Blueprint $table) {
            $table->string('speciality_photo')->nullable();
            
        });
          Schema::table('managers', function (Blueprint $table) {
            $table->string('profile_photo')->nullable();
            
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
        Schema::table('manager_specialities', function (Blueprint $table) {
            $table->dropColumn(['speciality_photo']);
        });
         //
        Schema::table('managers', function (Blueprint $table) {
            $table->dropColumn(['profile_photo']);
        });
    }
}
