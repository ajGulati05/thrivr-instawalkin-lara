<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Text;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\Boolean;
class ManagerSpeciality extends Resource
{
  

   public static $displayInNavigation = false;
     public static $group = 'Settings';
    use SoftDeletes;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\ManagerSpeciality';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'code';

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
            Text::make('Code')->rules('required'),
            Text::make('Description')->rules('required'),
             Text::make('Long Description')->rules('required'),
            File::make('Speciality Photo')->disk('s3')->path('specialities')->disableDownload(),
        Boolean::make('Default Value','default')
        ->trueValue('1')
        ->falseValue('0'),
            BelongsToMany::make('Managers')
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
    public static function label() {
        return 'Therapist Modalities';
    }
}
