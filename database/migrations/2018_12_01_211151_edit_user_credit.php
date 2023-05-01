<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditUserCredit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('creditreasoncodes', function (Blueprint $table) {
         
            $table->string('code', 4);
            $table->string('description');
            $table->primary(['code']);
            $table->timestamps();
        });

         Schema::table('credithistorys', function (Blueprint $table) {
               
               $table->string('reasoncode', 4)->nullable();
                $table->foreign('reasoncode')->references('code')->on('creditreasoncodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('creditreasoncodes');
    }
}
