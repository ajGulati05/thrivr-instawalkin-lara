<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAvailablityConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::table('availability_constraints', function (Blueprint $table) {
                $table->dropColumn(['availability_constraints']);
                $table->string('end_buffer')->default('15 minutes');
                $table->string('start_buffer')->default('60 minutes');
                $table->string('limit_future_bookings')->default('14');/// this is in days
            
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
