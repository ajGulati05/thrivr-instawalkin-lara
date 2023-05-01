<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnsubscribeStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unsubscribe_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('unsubscribe_track_id')->references('id')->on('unsubscribe_tracks');
            $table->boolean('all')->default(0);
            $table->boolean('receipts')->default(0);
            $table->boolean('booking')->default(0);
            $table->boolean('cancellation')->default(0);
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
        Schema::dropIfExists('unsubscribe_statuses');
    }
}
