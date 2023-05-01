<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBookingPricingsPaidby2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_pricings', function (Blueprint $table) {
               $table->decimal('amount_2',8,2)->nullable();
              
          
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::table('booking_pricings', function (Blueprint $table) {
               $table->dropColumn('amount_2');
               
                
        });
    }
}
