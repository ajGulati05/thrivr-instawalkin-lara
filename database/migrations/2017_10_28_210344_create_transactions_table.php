<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users');
            $table->integer('location_id')->references('id')->on('locations');
            $table->integer('service_id')->references('id')->on('services');
            $table->decimal('taxservice_id')->references('id')->on('tax_services');
            $table->decimal('serviceamount',5,2);
            $table->decimal('tipamount',10,2)->nullable();
            $table->decimal('taxamount',10,2)->nullable();
            $table->boolean('success')->nullable();
            $table->string('chargeid');
            $table->boolean('captured')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
