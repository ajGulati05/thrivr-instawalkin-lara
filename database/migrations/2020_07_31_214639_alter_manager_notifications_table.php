<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterManagerNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('manager_notifications', function (Blueprint $table) {
                $table->dropColumn(["text","desktop","desktopsound","web","websound","email","alwaysonline","switchtophone"]);
                $table->boolean('booking_texts')->default(1);
                $table->boolean('booking_emails')->default(1);
                $table->boolean('review_emails')->default(1);
                $table->boolean('endorsement_emails')->default(1);
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
