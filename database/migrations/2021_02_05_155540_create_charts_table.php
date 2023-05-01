<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('sequence')->default(1);
            $table->morphs('chartable');
            $table->text('data');
            $table->boolean('locked')->default(0);
            $table->unsignedInteger('manager_id');
            $table->unsignedBigInteger('userguest_id')->nullable();
            $table->uuid('parent_id')->nullable();
            $table->char('chart_types_code',4);
            $table->foreign('chart_types_code')->references('code')->on('chart_types');
                  $table->foreign('manager_id')->references('id')->on('managers');
            $table->foreign('userguest_id')->references('id')->on('user_guests');
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
        Schema::dropIfExists('charts');
    }
}
 