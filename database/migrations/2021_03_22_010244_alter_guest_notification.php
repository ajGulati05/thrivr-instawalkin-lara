<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGuestNotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('guests', function (Blueprint $table) {
            $table->boolean('text_reminder')->default(1);
            $table->boolean('email_reminder')->default(1);
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropColumn(['text_reminder','email_reminder']);
    }
}
