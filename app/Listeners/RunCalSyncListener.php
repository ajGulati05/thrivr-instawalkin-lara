<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Manager;
use App\Events\RunCalSyncEvent;
use App\Http\Traits\v2\ICSParserTrait;
use Illuminate\Support\Facades\Log;
class RunCalSyncListener
{

    use ICSParserTrait;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(RunCalSyncEvent $event)
    {
        $activeManagers=Manager::active()->where('product_code','A')->get();
        foreach($activeManagers as $manager){

                $icsURL=$manager->profiles->ics_url;


              if(!is_null($icsURL)){

              $constraints=$this->setBlockedTimes($manager,$icsURL);
              }                     
               
        }


    }
}
