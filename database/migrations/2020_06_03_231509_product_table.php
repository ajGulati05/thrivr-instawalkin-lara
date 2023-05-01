<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->char('code',1)->unique();
            $table->text('description');
            $table->timestamps();
        });
       
         Schema::create('manager_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('manager_id');
            $table->char('product_code',1);
            $table->boolean('status')->default('1');
            $table->timestamps();
            
        });
            Schema::table('manager_product', function (Blueprint $table) {
          
            $table->foreign('manager_id')->references('id')->on('managers');

            $table->foreign('product_code')->references('code')->on('products');

         });
             Schema::table('users', function (Blueprint $table) {
               $table->string('email')->nullable()->change();
              $table->string('password')->nullable()->change();
               $table->string('provider_id')->nullable();
               $table->string('provider')->nullable();
              $table->dropColumn(['stripe_id','card_brand','card_last_four','trial_ends_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::table('users', function (Blueprint $table) {
               $table->dropColumn(['provider','provider_id']);
                  $table->string('email')->nullable(false)->change();
              $table->string('password')->nullable(false)->change();
                   $table->string('stripe_id')->nullable()->collation('utf8mb4_bin')->index();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four', 4)->nullable();
            $table->timestamp('trial_ends_at')->nullable();
           });
         Schema::dropIfExists('manager_product');
         Schema::dropIfExists('products');
    }
}
