<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromocodetransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    Schema::create( 'promocodehistorys', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('promocode_id');
            $table->unsignedInteger('transaction_id');
            $table->timestamp('used_at');
            $table->primary(['user_id', 'promocode_id','transaction_id']);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->foreign('promocode_id')->references('id')->on(config('promocodes.table', 'promocodes'));
        });
       Schema::table('transactions', function (Blueprint $table) {
                $table->decimal('coupon_tax_calc',10,2)->nullable();
                $table->text('discount_type')->nullable(); //C credit, P promo
            });
        Schema::table('promocode_user', function (Blueprint $table) {
                $table->decimal('leftamount',10,2)->nullable();
             });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promocodehistorys');
    }
}
