<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvoiceTableAndCahsOnly extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //adding field for cashonly 
           Schema::table('locations', function (Blueprint $table) {
             $table->boolean('cashonly')->default(0);
        });

       Schema::table('transactions', function (Blueprint $table) {
               //hours is used to determine if independent of location hours i.e individuals
             $table->integer('durationvalue')->nullable();
        });


        //id
       //amount
          Schema::create('locationpercentages', function (Blueprint $table) {
               //hours is used to determine if independent of location hours i.e individuals
             $table->increments('id');
             //varied prices will be used to figure out wether notifications need to have an assigned employee
              $table->integer('location_id')->references('id')->on('locations');
              $table->integer('cashpaymentpercent')->default(10);
              $table->integer('creditpaymentpercent')->default(15);
              $table->decimal('creditpaymentcents',4,2)->nullable();
              $table->date('contract_start');
              $table->date('contract_end');

        });


          Schema::create('reciepts', function (Blueprint $table) {
               //hours is used to determine if independent of location hours i.e individuals
             $table->increments('id');
             //varied prices will be used to figure out wether notifications need to have an assigned employee
             $table->integer('transaction_id')->references('id')->on('transactions');
             $table->boolean('sentbymanager')->default(0);
             $table->boolean('requestedbyuser')->default(0);
             $table->dateTimeTz('sent_on');

        });

       Schema::create('invoices', function (Blueprint $table) {
               //hours is used to determine if independent of location hours i.e individuals
             $table->increments('id');
             //varied prices will be used to figure out wether notifications need to have an assigned employee
             $table->integer('location_id')->references('id')->on('locations');
             $table->decimal('amount',8,2)->nullable();
             $table->decimal('amountpaid',8,2)->nullable();
             $table->date('startdate');
             $table->date('enddate');
             $table->date('tobepaidby');
             $table->date('paidon');
             $table->dateTimeTz('sent_on');

        });   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('locationpercentages');
      Schema::dropIfExists('reciepts');
      Schema::dropIfExists('invoices');
        //
    }
}
