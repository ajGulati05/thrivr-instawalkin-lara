<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::dropIfExists('manager_product');
          Schema::table('managers', function (Blueprint $table) {
            $table->text('business_name')->nullable();
            $table->text('slug')->nullable();
           
        });
          Schema::table('manager_profiles', function (Blueprint $table) {
            $table->string('about',500)->nullable();
            
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
            $table->dropColumn('business_name');
            $table->dropColumn('slug');
        });
          Schema::table('manager_profiles', function (Blueprint $table) {
            $table->dropColumn('about');
       
        });
    }
}
