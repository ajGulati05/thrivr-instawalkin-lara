<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('bookings')) {

            Schema::create('bookings', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('manager_id');
                $table->unsignedInteger('project_id');
                $table->foreign('manager_id')->references('id')->on('managers');
                $table->foreign('project_id')->references('id')->on('projects');
                $table->dateTime('when')->nullable();
                $table->dateTime('start');
                $table->dateTime('end');
                $table->string('timekit_booking_id');
                $table->unsignedInteger('bookable_id'); //keep going
                $table->string('bookable_type'); //keep going

                $table->dateTime('date_to_authorize')->nullable(); //be aware of this
                $table->string('paid_by')->nullable(); //CASH OR DEBIT SEED, if a guest, automatically CASH
                $table->boolean('direct_billing')->default(false);
                $table->boolean('closed')->default(false);
                $table->boolean('tip_paid_separately')->default(false);
                $table->string('booking_status')->nullable(); //cancel or reschedule
                $table->string('status_changed_by')->nullable();
                $table->string('app_source')->nullable();
                $table->string('by_source')->nullable();

                $table->unsignedBigInteger('project_pricing_id')->nullable();
                $table->foreign('project_pricing_id')->references('id')->on('project_pricings');


                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
