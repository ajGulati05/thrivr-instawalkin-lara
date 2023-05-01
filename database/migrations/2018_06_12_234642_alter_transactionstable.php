<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTransactionstable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('transactions', function (Blueprint $table) {
               
                $table->integer('employee_id')->references('id')->on('employees')->nullable()->change();
                $table->decimal('serviceamount',5,2)->nullable()->change();
                $table->decimal('askedprice',5,2)->nullable();
                
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
