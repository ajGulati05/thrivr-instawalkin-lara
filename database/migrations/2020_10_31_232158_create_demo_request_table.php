<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemoRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo_requests', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('timekit_resource_id');
            $table->string('phone')->nullable();
            $table->string('name');
            $table->timestampTz('demo_date', 0);
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
        Schema::dropIfExists('demo_requests');
    }
}
