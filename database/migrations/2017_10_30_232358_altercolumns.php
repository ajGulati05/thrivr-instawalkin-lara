<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Altercolumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('locations', function (Blueprint $table) {
    $table->dropColumn(['locationtype_id']);
        });
       
           Schema::table('transactions', function (Blueprint $table) {
    $table->dropColumn(['taxservice_id']);
        });

          Schema::table('tax_services', function (Blueprint $table) {
            $table->dropColumn(['id','created_at','updated_at']);
            $table->primary(['tax_id','service_id']);
        });

 Schema::table('multi_service_locations', function (Blueprint $table) {
            $table->dropColumn(['id','created_at','updated_at']);
            $table->primary(['locationtype_id','location_id']);
        });
           Schema::table('stripedatas', function (Blueprint $table) {
                $table->softDeletes();
        });

               Schema::table('servicecategories', function (Blueprint $table) {
                $table->dropColumn(['locationtype_id']);
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
