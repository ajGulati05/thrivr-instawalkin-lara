<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectpricingsTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectpricings_taxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('project_pricing_id')->references('id')->on('project_pricings');
            $table->unsignedInteger('tax_id')->references('id')->on('taxes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projectpricings_taxes');
    }
}
