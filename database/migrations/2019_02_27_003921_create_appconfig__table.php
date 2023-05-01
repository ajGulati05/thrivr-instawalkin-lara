<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppconfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // day_start_hour -- start of the day hour
        //day_start_min  -- start of the day minutes
        // day_end_hour -- end of the day hour
        //day_end_min -- end of the day minutes
        //
        //month_to_add -- how many months to add for the date component to show
        Schema::create('appconfigs', function (Blueprint $table) {
            $table->string('codevalue')->unique();
            $table->text('description');
            $table->integer('value');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appconfigs');
    }
}
