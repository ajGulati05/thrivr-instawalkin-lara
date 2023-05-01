<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;
use Laravel\Nova\Fields\Select;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class PayoutReportAction extends DownloadExcel 


{
    use InteractsWithQueue, Queueable;

   

/**
 * Get the fields available on the action.
 *
 * @return array
 */
public function fields()
{
    return [
       Select::make('Type')->options([
    'W' => 'Willowgrove',
    'N' => 'Normal',
]),
    ];
}


public function getBookingStatusDescription($status){


    if($status=='C')
      {
        return 'Cancelled';
      }

    if($status=='R')
    {
      return 'Rescheduled';
    }  

    if($status=='D')
    {
        return 'Deleted';
    }
  
    return 'Confirmed';
}
  public function willowGrovePayout($booking,$topPricing){
            $percentage=0.15;
          
            $thrivrCommmision=(($topPricing->amount+$topPricing->tax_amount)*$percentage);
            return       [ $booking->id,
                $booking->manager->fullName,
            $booking->bookable->fullName,
             Carbon::parse($booking->start,'UTC')->setTimezone($booking->manager->timezone)->isoFormat('MMM Do, h:mm a'),
               
            $booking->project->description,
            $booking->paymentTypes->description,
             $this->getBookingStatusDescription($booking->booking_status),
            $topPricing->tip_amount,
            $topPricing->amount,
            $topPricing->tax_amount,
            $topPricing->discount_amount,
                Carbon::parse($booking->created_at,'UTC')->setTimezone($booking->manager->timezone)->isoFormat('MMM Do, h:mm a'),

                $thrivrCommmision];
  }

  public function normalPayout($booking,$topPricing){
       $percentage=0.03;
        $creditPercentage=.029;
        $creditCents=0.30;
        $thrivrCommmision=($topPricing->amount+$topPricing->tax_amount)*$percentage;
$thrivrCreditCommission=0;
        if($booking->paid_by=='CR'){
                 $thrivrCreditCommission=($topPricing->amount*$creditPercentage)+$creditCents;
        }


            return  [ $booking->id,
                $booking->manager->fullName,
            $booking->bookable->fullName,
            Carbon::parse($booking->start,'UTC')->setTimezone($booking->manager->timezone)->isoFormat('MMM Do, h:mm a'),

            $booking->project->description,
            $booking->paymentTypes->description,   
            $this->getBookingStatusDescription($booking->booking_status),
            $topPricing->tip_amount,
            $topPricing->amount,
            $topPricing->tax_amount,
            $topPricing->discount_amount,
                Carbon::parse($booking->created_at,'UTC')->setTimezone($booking->manager->timezone)->isoFormat('MMM Do, h:mm a'),

            $thrivrCommmision,
            $thrivrCreditCommission];


  }

    /**
     * @param User $user
     *
     * @return array
     */
    public function map($booking): array
    {
      
     
         $topPricing=  $booking->topActiveBookingPricing();   

      $payout=$this->normalPayout($booking,$topPricing);


        if($this->request->type=='W'){
            $percentage=15;
            $creditPercentage=0;
            $creditCents=0;
         $payout=$this->willowGrovePayout($booking,$topPricing);
        }
      

        return [
     
$payout

        ];
    }
}
