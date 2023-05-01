<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesForRmtsupport extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
                 Schema::create('user_recommended_rmt', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->text('therapist_name');
            $table->boolean('connected');
            $table->timestamps();
            
        });
 Schema::table('user_recommended_rmt', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
         });
          Schema::create('scheduling_systems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('description');
            $table->boolean('twoway_calendar_sync');
            $table->timestamps();
        });
           Schema::create('associations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('name');
            $table->timestamps();
        });
        Schema::create('applied_rmts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('firstname');
            $table->text('lastname');
            $table->text('businessname');
             $table->text('address');
            $table->text('city');
            $table->text('province');
            $table->string('postalcode',7);
            $table->boolean('self')->default(true);
            $table->text('website')->nullable();
            $table->string('phone',11);
            $table->boolean('approved')->default(false);
            $table->timestamp('approved_on')->nullable();
            $table->text('reason')->nullable();
            $table->boolean('listing')->default(false);
            $table->boolean('scheduling')->default(false);
            $table->unsignedBigInteger('scheduling_system_id');
            $table->text('other_scheduling')->nullable();
            $table->unsignedBigInteger('association_id');
            $table->text('other_association')->nullable();
            $table->timestamps();
            
        });

   
         Schema::table('applied_rmts', function (Blueprint $table) {
             $table->foreign('scheduling_system_id')->references('id')->on('scheduling_systems');
              $table->foreign('association_id')->references('id')->on('associations');
         });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
       
      
            Schema::dropIfExists('applied_rmts');
            Schema::dropIfExists('user_recommended_rmt');
            Schema::dropIfExists('associations');
            Schema::dropIfExists('scheduling_systems');
         
    
       
    }
}
