<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCardTokenStripedatass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stripedatas', function (Blueprint $table) {
            $table->string('card_token')->nullable();
            $table->boolean('default_card')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stripedatas', function (Blueprint $table) {
            $table->dropColumn(['card_token','default_card']);

        });
    }
}
