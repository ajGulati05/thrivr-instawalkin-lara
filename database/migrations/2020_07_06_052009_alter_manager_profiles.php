<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterManagerProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::table('manager_profiles', function (Blueprint $table) {
               $table->text('extra_information')->nullable();
               $table->boolean('direct_billing')->default(1)->change();
                
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
                $table->dropColumn('extra_information');
               $table->boolean('direct_billing')->default(1)->change();
                });
    }
}
