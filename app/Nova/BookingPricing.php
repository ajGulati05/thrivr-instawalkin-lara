<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Boolean;
use Carbon\Carbon;
use Laravel\Nova\Fields\HasMany;
class BookingPricing extends Resource
{
    public static $displayInNavigation = false;
   
    
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\BookingPricing';

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
             Text::make('Amount'),
            Text::make('Tax Amount'),
             Text::make('Tip Amount'),
             Text::make('Credit Card Amount'),
             Text::make('Discount Amount'),
             Text::make('Cash Amount'),
             Text::make('Direct Billing Amount'),
            Boolean::make('Status','active')
                 ->trueValue('1')
                 ->falseValue('0'),
            HasMany::make('BookingTransaction'),
            BelongsTo::make('Booking'),
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
}
