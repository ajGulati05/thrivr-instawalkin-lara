<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCTARecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('c_t_a_records', function (Blueprint $table) {
           $table->string('source')->default('webapp');
           $table->softDeletes();
           });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('c_t_a_records', function (Blueprint $table) {
           $table->dropColumn('source');
           $table->dropSoftDeletes();
           });
    }
}
