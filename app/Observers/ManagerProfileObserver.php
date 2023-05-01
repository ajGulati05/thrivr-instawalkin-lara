<?php

namespace App\Observers;

use Grimzy\LaravelMysqlSpatial\Types\Point;
use App\ManagerProfile;

class ManagerProfileObserver
{
    /**
     * Handle the manager "created" event.
     *
     * @param  \App\Manager  $manager
     * @return void
     */
    public function created(ManagerProfile $managerProfile)
    {
     

    	$position=new Point($managerProfile->latitude, $managerProfile->longitude,4326);
    	$managerProfile->position=$position;
    	$managerProfile->save();
 
    }

  
}

