<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Boolean;
use GeneaLabs\NovaMapMarkerField\MapMarker;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
class LaunchedCities extends Resource
{

     public static $group = 'Settings';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\LaunchedCities::class;

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
              Text::make('City','city_name'),
                Text::make('Timezone','timezone'),
             Boolean::make('Status', 'status')
                ->trueValue('1')
                ->falseValue('0'),  
            MapMarker::make("Location")
             ->latitude('latitude')
               ->longitude('longitude')
            ->defaultLatitude(52.1017216)
            ->defaultLongitude(-106.5692332)
             ->required(),
         HasMany::make('Teams', 'rmtTeam','App\Nova\RmtTeam')
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
