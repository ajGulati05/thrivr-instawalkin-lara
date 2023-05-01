<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FkProductManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::table('managers', function (Blueprint $table) {
            
            $table->char('product_code',1)->nullable();  
    });
 
 Schema::table('managers', function (Blueprint $table) {
      $table->foreign('product_code')->references('code')->on('products');
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
