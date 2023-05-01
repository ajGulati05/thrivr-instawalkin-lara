<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLaravelNova extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('action_events', function (Blueprint $table) {
            
            $table->dropIndex('action_events_actionable_type_actionable_id_index');
 
            $table->dropIndex('action_events_batch_id_model_type_model_id_index');
             $table->dropColumn(['user_id', 'target_id', 'actionable_id','model_id']);

         });
         Schema::table('action_events', function (Blueprint $table) {
           
         
            $table->string('user_id')->index();
            $table->string('target_id');
            $table->string('actionable_id');
            $table->string('model_id')->nullable();

            $table->index(['actionable_type', 'actionable_id']);
            $table->index(['batch_id', 'model_type', 'model_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('action_events', function (Blueprint $table) {
           
            $table->dropIndex('action_events_actionable_type_actionable_id_index');
 
            $table->dropIndex('action_events_batch_id_model_type_model_id_index');
              $table->dropColumn(['user_id', 'target_id', 'actionable_id','model_id']);

         });
           Schema::table('action_events', function (Blueprint $table) {
                
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('target_id');
            $table->unsignedInteger('actionable_id');
            $table->unsignedInteger('model_id')->nullable();


             $table->index(['actionable_type', 'actionable_id']);
            $table->index(['batch_id', 'model_type', 'model_id']);
        });
    }
}
