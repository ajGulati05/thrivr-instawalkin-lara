<?php

namespace App\Http\Traits\v2;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use ICal\ICal;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;
trait ICSParserTrait
{


    public function setBlockedTimes($manager,$icsURL)
    {
   
        if(!Str::contains($icsURL, '.ics'))
        {
       
           $icsURL= $this->ifWebCalFetchData($icsURL);
        
        }

try {


    $ical = new ICal($icsURL, array(
        'defaultSpan'                 => 2,     // Default value
        'defaultTimeZone'             => 'America\Regina',
        'defaultWeekStart'            => 'SU',  // Default value
        'disableCharacterReplacement' => false, // Default value
        'filterDaysAfter'             => null,  // Default value
        'filterDaysBefore'            => 1,  // Default value
        'skipRecurrence'              => false, // Default value
    ));
          $showExample = array(
            'interval' => true,
            'range'    => true,
            'all'      => true,
        );

       
         
       if ($showExample['interval']) {
            $events = $ical->eventsFromInterval('4 weeks');
            $this->createBlockedArray($manager,$icsURL,$events);
           
}

          
   } catch (\Exception $e) {
 
      Log::critical('Manager calendar issue'.$icsURL);

    $blockNext5Weeks=$this->blockNextFiveWeeks();
    Redis::del($manager->timekit_resource_id);
    Redis::hmset($manager->timekit_resource_id,[$blockNext5Weeks]); 
} 
           
    }


public function blockNextFiveWeeks(){
    $startdate=Carbon::now()->setTimezone('America/Regina')->toIso8601String();
    $enddate=Carbon::now()->addWeeks(5)->setTimezone('America/Regina')->toIso8601String();
    $blockedWeeks='{"block_period": {"start": "'.$startdate.'","end":"'.$enddate.'"}  }';

    return $blockedWeeks;
}

public function createBlockedArray($manager,$icsURL, $events){
 $blockedTimesArray =  array();

$count=0;
foreach($events as $event){



    $startdate=Carbon::parse($event->dtstart_tz)->setTimezone('America/Regina')->toIso8601String();
    $enddate=Carbon::parse($event->dtend_tz)->setTimezone('America/Regina')->toIso8601String();

    $y='{"block_period": {"start": "'.$startdate.'","end":"'.$enddate.'"}  }';
     
   
   array_push($blockedTimesArray,$y);
   
   
                         
                       
}


 Redis::del($manager->timekit_resource_id);
 Redis::hmset($manager->timekit_resource_id, $blockedTimesArray);


}


public function ifWebCalFetchData($icsURL){
     $response = Http::get($icsURL);
        Storage::disk('local')->put('example.ics',$response);
       return storage_path("app/example.ics");

      
}


public function getBlockedTimes($resource_id){
   
    $blockedTimes=  Redis::hgetall($resource_id);


    $blockedTimesArray =  array();
    foreach($blockedTimes as $blockedTime){
         $x= json_decode($blockedTime,JSON_UNESCAPED_SLASHES);

          array_push($blockedTimesArray, $x);
    }
   
      if(empty($blockedTimes)){
      $blockNext5Weeks=$this->blockNextFiveWeeks();
       $encodedBlockNextFiveWeeks= json_decode($blockNext5Weeks,JSON_UNESCAPED_SLASHES);
        array_push($blockedTimesArray,$encodedBlockNextFiveWeeks);
   }
    return $blockedTimesArray;
}


}
