<?php

use Illuminate\Database\Seeder;

use App\Endorsement;
class ManagersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	 
          factory(App\Manager::class, 6)->states('booking')
           ->create()
           ->each(function ($manager) {
            $ran = array(1,2,4,5,6);
            $k = array_rand($ran);
$v = $ran[$k];
                $manager->manager_profiles()->save(factory(App\Managerprofile::class)->make());
               	$project_id=App\Project::all()->pluck('id');
               	$manager_speciality=App\ManagerSpeciality::all()->pluck('id');
                $manager->projects()->attach($project_id->all() );
                $manager->manager_specialities()->attach($manager_speciality->random($v) );
                $manager->manager_licenses()->save(factory(App\ManagerLicense::class)->make());
                $manager->bookings()->createMany(factory(App\Booking::class,20)->make()->toArray());
               
                });
            



             factory(App\Manager::class, 6)->states('listing')
           ->create()
           ->each(function ($manager){
  $ran = array(1,2,4,5,6);
               $k = array_rand($ran);
$v = $ran[$k];
            $manager->manager_profiles()->save(factory(App\Managerprofile::class)->make());
              $project_id=App\Project::all()->pluck('id');
                $manager_speciality=App\ManagerSpeciality::all()->pluck('id');
                $manager->projects()->attach($project_id->all() );
                $manager->manager_specialities()->attach($manager_speciality->random($v) );
                $manager->manager_licenses()->save(factory(App\ManagerLicense::class)->make());
           });
    }
}
