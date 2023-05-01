<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGuestAddManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('guests', function (Blueprint $table) {
            
                $table->unsignedInteger('manager_id')->nullable();
                $table->foreign('manager_id')->references('id')->on('managers');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {             $table->dropForeign(['manager_id']);
              $table->dropColumn(['manager_id']);
              
    }
}
