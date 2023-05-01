<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpoTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('service_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('description');
            $table->timestamps();
        });
         Schema::table('users', function (Blueprint $table) {
            $table->text('expotoken')->nullable()->after('password');
            $table->boolean('status')->default(1)->after('password');
        }); 

         Schema::table('transactions', function (Blueprint $table) {
            $table->string('service_response_code')->references('code')->on('service_response');
           
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_responses');
    }
}
