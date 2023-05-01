<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClientsTherapists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('client_therapist', function (Blueprint $table) {
                $table->id();    
                $table->unsignedInteger('manager_id');
                $table->unsignedInteger('user_id');
                $table->boolean('blocked')->default(0);
                $table->text('reason')->nullable();
                $table->timestamps();
                $table->foreign('manager_id')->references('id')->on('managers');
                $table->foreign('user_id')->references('id')->on('users');
                


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_therapist');
    }
}
