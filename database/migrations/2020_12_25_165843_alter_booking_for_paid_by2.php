<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBookingForPaidBy2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('bookings', function (Blueprint $table) {
               $table->char('paid_by_2',3)->nullable();
               

               $table->foreign('paid_by_2')->references('code')->on('payment_types');
             
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('bookings', function (Blueprint $table) {
               $table->dropColumn('paid_by_2');
             
                
        });
    }
}
