<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransactionTableTipChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('transactions', function (Blueprint $table) {
               
              $table->boolean('tipcaptured')->default(0);
              $table->boolean('tipsuccess')->default(0);
              $table->string('tipchargeid')->nullable();
              $table->dateTime('tipdate_at')->nullable();
              $table->boolean('transactionclosed')->default(0);
              $table->string('userreasons')->nullable();
              $table->string('transactionreasons')->nullable();
                
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
