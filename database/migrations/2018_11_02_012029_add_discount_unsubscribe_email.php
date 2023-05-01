<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscountUnsubscribeEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('transactions', function (Blueprint $table) {
               
                $table->integer('coupon_percent')->nullable();
                $table->decimal('coupon_amount_calc',10,2)->nullable();
                
        });

           Schema::table('users', function (Blueprint $table) {
               
              $table->boolean('subscribed')->default(1);
                
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
