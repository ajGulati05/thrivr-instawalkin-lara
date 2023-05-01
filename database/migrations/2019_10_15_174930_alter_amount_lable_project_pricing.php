<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAmountLableProjectPricing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('project_pricings', function (Blueprint $table) {
            $table->renameColumn('ammount', 'amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_pricings', function (Blueprint $table) {
            $table->renameColumn('amount', 'ammount');
        });
    }
}
