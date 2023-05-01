<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsernotificationsTablePart2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::table('user_notifications', function (Blueprint $table) {
            $table->dropcolumn(['viapush','viatext','allnotifications']);
            $table->boolean('text_reminder')->default(1);
            $table->boolean('email_reminder')->default(1);
            $table->boolean('email_receipt')->default(1);
            $table->boolean('email_confirmation')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
    }
}
