<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Boolean;
use Carbon\Carbon;

use Laravel\Nova\Fields\Status;
use Inspheric\Fields\Indicator;
use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\MorphTo;

use App\Nova\User;
use App\Nova\Guest;

use App\Nova\Filters\BookingDatesFilter;
use App\Nova\Filters\BookingEndDatesFilter;
use App\Nova\Actions\PayoutReportAction;
class Booking extends Resource
{
   
     public static $group = 'Bookings';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Booking';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
          Indicator::make('Status','booking_status')
    ->labels([
        'R' => 'Rescheduled',
        'C' => 'Cancelled',
       
    ])->unknown('Booked')
      ->colors([
        'C' => 'red',
        'R' => 'blue'
      
    ]),

   Text::make('Manager', function () { return $this->manager->first_name.' '.$this->manager->last_name; }) ->onlyOnIndex(),
     
            Text::make('Duration', function () { return $this->project->description; }) ->onlyOnIndex(),
            Text::make('Start', function () { return Carbon::parse($this->start,'UTC')->setTimezone('America/Regina')->isoFormat('MMM Do, h:mm a');}) ->onlyOnIndex(),
            Text::make('End',function () { return Carbon::parse($this->end,'UTC')->setTimezone('America/Regina')->isoFormat('MMM Do, h:mm a');}) ->onlyOnIndex(),
            Text::make('User',function () { return $this->bookable?$this->bookable->fullName:null; }) ->onlyOnIndex(),
            Text::make('Bookable Type'),
            Text::make('Date To Authorize'),
                Text::make('Paid By'),

               Boolean::make('Direct Billing')
                 ->trueValue('1')
        ->falseValue('0'),
           Boolean::make('Closed')
        ->trueValue('1')
        ->falseValue('0'),
  
        Text::make('Status Changed By'),
        Text::make('App Source'),
        Text::make('By Source'),
         Text::make('Status Change Date',function () { return Carbon::parse($this->status_changed_date,'UTC')->setTimezone('America/Regina')->isoFormat('MMM Do, h:mm a');}) ->onlyOnIndex(),
         Text::make('Status Initiated By'),
    Text::make('Status Initiated On',function () { return Carbon::parse($this->status_initiated_on,'UTC')->setTimezone('America/Regina')->isoFormat('MMM Do, h:mm a');}) ->onlyOnIndex(),
        //Text::make('Speciality',function () { return $this->managerspeciality->description; }) ->onlyOnIndex(),
        //Text::make('Pricing',function () { return $this->project_pricing->amount; }) ->onlyOnIndex(),
        HasOne::make('Manager'),

            HasMany::make('Pricing', 'booking_pricings','App\Nova\BookingPricing'),
      // BelongsTo::make('ManagerSpeciality', 'Manager Specialities'),
        ];
    }

    /*project_id` int(10) unsigned NOT NULL,
  `when` datetime DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `timekit_booking_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bookable_id` int(10) unsigned NOT NULL,
  `bookable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_to_authorize` datetime DEFAULT NULL,
  `paid_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direct_billing` tinyint(1) NOT NULL DEFAULT '0',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `tip_paid_separately` tinyint(1) NOT NULL DEFAULT '0',
  `booking_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_changed_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_source` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `by_source` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_pricing_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `manager_speciality_id` bigint(20) unsigned DEFAULT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_changed_date` datetime DEFAULT NULL,
  `status_initiated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_initiated_on` datetime DEFAULT NULL,()*/

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [new BookingDatesFilter, new BookingEndDatesFilter];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
       
    
    return [
            (new PayoutReportAction)->withHeadings('#','Therapist Name', 'Name', 'Date','Treatment','Payment Type','Booking Status','Tip','Service amount','GST 5%','Discount Amount','Created At','Thrivr Comission','Credit Card Charge')];
    }

           public static function authorizable()
{
    return false;
}
}
