<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntakeFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        
        Schema::create('intake_forms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->morphs('intakeform');
            $table->unsignedBigInteger('userguest_id')->nullable();
            $table->boolean('active');
            $table->text('name');
            $table->text('address');
            $table->text('phone');
            $table->text('birthdate');
            $table->text('referred_by')->nullable();
            $table->text('physician_name')->nullable();
            $table->text('allergies')->nullable();
            $table->text('sports_activities')->nullable();
            $table->text('current_medications')->nullable();
            $table->text('heart')->nullable();
            $table->text('blood_pressure')->nullable();
            $table->text('fainting_dizziness')->nullable();
            $table->text('varicose_veins')->nullable();
            $table->text('phkebitis_circulatory')->nullable();
            $table->text('headaches_migraine')->nullable();
            $table->text('neck_injury')->nullable();
            $table->text('back_injury')->nullable();
            $table->text('jaw_ear')->nullable();
            $table->text('osteoporosis')->nullable();
            $table->text('arthritis')->nullable();
            $table->text('osteoarthritis')->nullable();
            $table->text('cancer')->nullable();
            $table->text('kidney_disease')->nullable();
            $table->text('diabetes')->nullable();
            $table->text('asthma')->nullable();
            $table->text('fibromyalgia')->nullable();
            $table->text('crohn')->nullable();
            $table->text('pelvic')->nullable();
            $table->text('epilepsy')->nullable();
            $table->text('nervous')->nullable();
            $table->text('whiplash')->nullable();
            $table->text('medical_other')->nullable();
            $table->text('physiotherapist')->nullable();
            $table->text('chiropractor')->nullable();
            $table->text('massage_therapist')->nullable();
            $table->text('naturopath')->nullable();
            $table->text('care_other')->nullable();
            $table->text('care_reason')->nullable();
            $table->text('number_treatments')->nullable();
            $table->text('surgery')->nullable();
            $table->text('surgery_reason')->nullable();
            $table->text('fractures')->nullable();
            $table->text('fractures_reason')->nullable();
            $table->text('illness')->nullable();
            $table->text('illness_reason')->nullable();
            $table->text('motor_workplace')->nullable();
            $table->text('physician_exam')->nullable();
            $table->text('xray')->nullable();
            $table->text('other_tests')->nullable();
            $table->text('relievies')->nullable();
            $table->text('aggravates')->nullable();
            $table->text('consent_1');
            $table->text('consent_2');
            $table->text('consent_3');
            $table->text('consent_4');
            $table->text('consent_5');
            $table->text('consent_6');
            $table->timestamps();


            $table->foreign('userguest_id')->references('id')->on('user_guests');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intake_forms');
    }
}
