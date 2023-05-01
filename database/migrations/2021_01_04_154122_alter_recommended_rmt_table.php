<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRecommendedRmtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
    Schema::table('user_recommended_rmt', function (Blueprint $table) {
         $table->string('therapist_business')->nullable();
         $table->string('therapist_email')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
             Schema::create('user_recommended_rmt', function (Blueprint $table) {
                        $table->dropColumn(['therapist_business','therapist_email']);
            
        });
    }
}
