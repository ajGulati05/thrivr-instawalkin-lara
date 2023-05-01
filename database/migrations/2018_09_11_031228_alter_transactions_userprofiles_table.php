<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTransactionsUserprofilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('transactions', function (Blueprint $table) {
               
              $table->boolean('wrongamount')->default(0);
                
        });

            Schema::table('userprofiles', function (Blueprint $table) {
               
              $table->boolean('introskip')->default(0);
              $table->boolean('instafirstclick')->default(0);
                
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
