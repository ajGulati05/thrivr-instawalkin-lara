<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagerNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manager_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('manager_id')->references('id')->on('managers');
            $table->boolean('desktop')->default(1);
            $table->boolean('desktopsound')->default(1);
            $table->boolean('web')->default(1);
            $table->boolean('websound')->default(1);
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
        Schema::dropIfExists('manager_notifications');
    }
}
