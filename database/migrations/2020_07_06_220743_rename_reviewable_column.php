<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameReviewableColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('reviews', function (Blueprint $table) {
               //hours is used to determine if independent of location hours i.e individuals
          $table->renameColumn('review_id', 'reviewable_id');
         $table->renameColumn('review_type', 'reviewable_type');
         $table->integer('parent_id')->unsigned()->nullable()->change();
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('reviews', function (Blueprint $table) {
          $table->renameColumn( 'reviewable_id','review_id');
          $table->renameColumn( 'reviewable_type','review_type');
         $table->integer('parent_id')->unsigned()->default(0)->change();
      }); 
    }
}
