<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Bissolli\NovaPhoneField\PhoneNumber;
use Dniccum\PhoneNumber\PhoneNumber as DniccumPhoneNumber;
use Laravel\Nova\Fields\Boolean;
use GeneaLabs\NovaMapMarkerField\MapMarker;
use Laravel\Nova\Fields\Trix;
class ManagerProfile extends Resource
{
      public static $displayInNavigation = false;
     
      public static $group = 'Therapists';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\ManagerProfile';

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

            BelongsTo::make('managers'),
     

            Text::make('address'),
            MapMarker::make("Location")
            ->defaultLatitude(52.1017216)
            ->defaultLongitude(-106.5692332),


            Text::make('postal_code'),
            Text::make('city'),
            Text::make('province'),
             Trix::make('about'),
         
            // ->postalCode('Postal Code')
            // ->latitude('Latitude')
            // ->longitude('Longitude'),

            PhoneNumber::make('Phone Number', 'phone'),

      

           

         
            Boolean::make('Free Parking', 'parking')
                ->trueValue('1')
                ->falseValue('0'),

            Boolean::make('Direct Billing', 'direct_billing')
                ->trueValue('1')
                ->falseValue('0'),   
                    Text::make('Address Description', 'address_description'),
                    Text::make('Parking Description', 'parking_description'),
             
            Text::make('Tag Line', 'tag_line')
                ->rules('required'),
           Text::make('ICS', 'ics_url'),
        ];
    }

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
        return [];
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
        return [];
    }

    public static function label()
    {
        return 'Therapist Profiles';
    }
}
