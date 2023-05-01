<?php

namespace Tests\feature;

use App\Booking;
use App\Manager;
use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateUserBookingsTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function create_a_user_booking_by_user()
    {
        //Arrange
        //set the booking data
        $manager = Manager::first();
        $project = Project::first();
        $user=User::first();
        $booking = Booking::create([
            'manager_id' => $manager->manager_id,
            'project_id' => $project_id,
            'when' => Carbon::now(),
            'start' => Carbon::now(),
            'end' => Carbon::now(),
            'timekit_booking_id' => '1',
            'bookable_id' => $user->id,
            'bookable_type' => User,
            'paid_by' => 'CA',
            'booking_status' => null,


        ]);
        /*  `status_changed_by
          `app_source`
          `by_source`
          `project_pricing_id`
          `created_at`
          `updated_at`
          `manager_speciality_id`
          `reason`
          `status_changed_date`
          `status_initiated_by`
          `status_initiated_on`
          `userguest_id`
          `parent_id`
          `paid_by_2`*/
        //Act 


        //Assert
    }

    /** @test */
    public function create_a_user_booking_by_user_using_promo_code()
    {
        //Arrange


        //Act 


        //Assert
    }

    /** @test */
    public function create_a_user_booking_by_user_using_referral_code()
    {
        //Arrange


        //Act 


        //Assert
    }


}
