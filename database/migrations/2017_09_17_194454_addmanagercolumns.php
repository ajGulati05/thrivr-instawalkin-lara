<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Addmanagercolumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('managers', function (Blueprint $table) {
            $table->boolean('emailsent')->default(0)->after('password');
            $table->boolean('emailconfirmed')->default(0)->after('emailsent');
            $table->boolean('status')->default(1)->after('emailconfirmed');
            $table->string('statusreason')->nullable()->after('status');
            

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
