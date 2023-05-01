<?php

namespace App\Http\Controllers\Managersapi\Analytics;

use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;
use App\Manager;
class TherapistGoogleAnalyticsController extends Controller
{
  
  protected $therapist;
  protected $days;

//total bookings
//total amount earned
//New Patients??
protected $defaultFilter="ga:date";
protected $dateFilter="ga:date";
protected $monthFilter="ga:month";

public function get($days){
  $this->therapist =  Auth::user();
  $this->days=$days;

  if($days==90||$days==365)
{
  $this->defaultFilter=$this->monthFilter;
}


  $profileClicks =$this->getProfileClicks();
  $googlePageViews=$this->getGooglePageViews();
  $phoneClicks=$this->getPhoneClicks();
  $sessionTime=$this->getSessionStats();

  return response()->json([
   
    "profileClicks"=>["total"=>$profileClicks->totalsForAllResults,"rows"=>$profileClicks->rows,"tooltip"=>"Number of times your profile has been clicked in {$days} days"],
    "googlePageViews"=>["total"=>$googlePageViews->totalsForAllResults,"rows"=>$googlePageViews->rows,"tooltip"=>"Number of times your profile has been viewed on in {$days} days"],
    'phoneClicks'=>$this->therapist->product_code==Manager::ALL_PRODUCTS?null:["total"=>$phoneClicks->totalsForAllResults,"rows"=>$phoneClicks->rows,"tooltip"=>"Number of times your phone number has been clicked on in {$days} days"],
    'sessionStats'=>["total"=>$sessionTime->totalsForAllResults,"rows"=>$sessionTime->rows,"tooltip"=>"Number of seconds users have combined spent on your page in {$days} days"]
  ]);


}
 

public function getGooglePageViews(){
  $analyticsData = Analytics::performQuery(
    Period::days($this->days),
    'ga:sessions',
    [
        'metrics' => 'ga:pageviews,ga:uniquePageViews',
        'dimensions' => $this->defaultFilter,
        'filters'=>'ga:pagePath=@'.$this->therapist->slug
    ]
);
  return $analyticsData;

  }





public function getPhoneClicks(){
$analyticsData = Analytics::performQuery(
    Period::days($this->days),
    'ga:sessions',
    [
        'metrics' => 'ga:totalEvents',
        'dimensions' => $this->defaultFilter,
        'filters'=>'ga:eventCategory=='.$this->therapist->slug.'_telephone'
    ]
);
  return $analyticsData;
}


/*profile clicks:

'metrics' => 'ga:totalEvents',
'dimensions' => 'ga:eventCategory'
'filters' => 'ga:eventCategory==MANAGER_SLUG_HERE_profile
*/

public function getProfileClicks(){


$analyticsData = Analytics::performQuery(
    Period::days($this->days),
    'ga:sessions',
    [
        'metrics' => 'ga:totalEvents',
        'dimensions' => $this->defaultFilter,
        'filters'=>'ga:eventCategory=='.$this->therapist->slug.'_profile'
    ]
);
  return $analyticsData;


}
 
  public function getSessionStats(){


 $analyticsData = Analytics::performQuery(
    Period::days($this->days),
    'ga:sessions',
    [
        'metrics' => 'ga:sessionDuration,ga:avgTimeOnPage',
        'dimensions' => $this->defaultFilter,
        'filters'=>'ga:pagePath=@'.$this->therapist->slug
    ]
);
  return $analyticsData;
  }



  public function getAverageReturnRate(){


 $analyticsData = Analytics::performQuery(
    Period::days($this->days),
    'ga:sessions',
    [
        'metrics' => 'ga:sessionDuration,ga:avgTimeOnPage',
        'dimensions' => $this->defaultFilter,
        'filters'=>'ga:pagePath=@'.$this->therapist->slug
    ]
);
  return $analyticsData;
  }




}

//ga:eventCategory=@EEcommerce