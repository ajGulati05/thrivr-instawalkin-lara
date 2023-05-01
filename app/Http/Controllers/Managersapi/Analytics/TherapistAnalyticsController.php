<?php

namespace App\Http\Controllers\Managersapi\Analytics;

use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Analytics\Period;
use Carbon\Carbon;
use App\Manager;
use App\Booking;

class TherapistAnalyticsController extends Controller
{
  
  protected $therapist;
  protected $days;
  protected $bookingIds;
  protected $defaultFilter="DATE_FORMAT(created_at,'%d-%b') as filterValue";

  protected $monthFilter="DATE_FORMAT(created_at,'%b') as filterValue";
  protected $dateFilter="DATE_FORMAT(created_at,'%d-%b') as filterValue";


 


public function get($days){
  $this->therapist =  Auth::user();
  $this->days=$days;

if($days==90||$days==365)
{
  $this->defaultFilter=$this->monthFilter;
}

  $this->bookingIds= $this->therapist->bookings
      ->whereBetween('start',Period::days($this->days))
      ->whereNull('booking_status')
      ->pluck('id');
  
  $topTreaments=$this->getTopTreatments();
  $reviewStats=$this->getReviewStats();
  $getUniquePatientCount=$this->getUniquePatientCount();
  $getTotalVisits=$this->getTotalVisits();
  $getTotalBilled=$this->getTotalBilled();

 
  return response()->json([
   
     "uniqueClients"=>$getUniquePatientCount,
    'totalBookings'=>$getTotalVisits,
    'getTotalBilled'=>$getTotalBilled,
    'reviewStats'=>$reviewStats,
    'topTreaments'=>$topTreaments
  ]);


}
 
 //$this->therapist->product_code==Manager::ALL_PRODUCTS?null:



public function getUniquePatientCount(){
  



  $unique= DB::table('bookings')
                       ->select(DB::raw('DISTINCT bookable_type, bookable_id'))   
                        ->whereIn('id',$this->bookingIds) 
                        ->selectRaw($this->defaultFilter)       
                        ->groupBy(['bookable_type','bookable_id','userguest_id','filterValue'])
                       ->get();



 return ["data"=>$unique->countBy('filterValue'),"total"=>$unique->groupBy('filterValue')->count(),"tooltip"=>"Number of unique clients in {$this->days} days"];

}


public function getTotalVisits(){
  $bookingsFilter= 
  DB::table('bookings')
        ->select(Db::raw('count(*) as total'))
        ->selectRaw($this->defaultFilter)       
       ->distinct()
       ->whereIn('id',$this->bookingIds) 
       ->groupBy(['filterValue'])
       ->get();


  return ["data"=>$bookingsFilter->groupBy('filterValue'),"total"=>$this->bookingIds->count(),"tooltip"=>"Number of total appointments in {$this->days} days"];
}


public function getTotalBilled(){
   $allBookingIds= $this->therapist->bookings
      ->whereBetween('start',Period::days($this->days))
      ->pluck('id');

      $bookingPricingsSum=DB::table('booking_pricings')
             ->select(DB::raw('IFNULL(sum(amount),0)+IFNULL(sum(tax_amount),0)+IFNULL(sum(amount_2),0) as total,IFNULL(sum(tip_amount),0) as total_tip'))
             ->selectRaw($this->defaultFilter)
             ->distinct()
             ->whereIn('booking_id',$allBookingIds)
             ->where('active',1)
             ->groupBy('filterValue')
             ->get();


  


      return ["data"=>$bookingPricingsSum,"totalBilled"=>$bookingPricingsSum->sum('total'),"totalTip"=>$bookingPricingsSum->sum('total_tip'),"tooltip"=>"Amount billed in {$this->days} days"];




}




public function getReviewStats(){

  $reviewsID=$this->therapist->reviews
  ->whereBetween('created_at',Period::days($this->days))
  ->pluck('id');



 $brokenDownreviews= DB::table('reviews')
                       ->select(DB::raw('count(*) as score_count,score'))   
                       ->whereIn('id',$reviewsID)        
                       ->groupBy('score')
                       ->get();

  $brokenDownEndorsements=DB::table('endorsement_review')
                       ->select(DB::raw('count(*) as endorsement,endorsement_id'))   
                       ->whereIn('review_id',$reviewsID)    
                      ->groupBy('endorsement_id')    
                       ->get();

  return ["reviewAnalytics"=>$brokenDownreviews,"endorsemntAnalytics"=>$brokenDownEndorsements,"tooltip"=>"Number of reivews in {$this->days} days"];               

}


public function getTopTreatments(){






 $topTreatments=  DB::table('bookings')
                       ->select(DB::raw('count(*) as project_count,project_id'))   
                       ->whereIn('id',$this->bookingIds)        
                       ->groupBy('project_id')
                       ->get();


return ['topTreaments'=>$topTreatments,"tooltip"=>"Top treatments in the last {$this->days} days"];
}






}

//ga:eventCategory=@EEcommerce