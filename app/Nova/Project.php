<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use App\Nova\Actions\CreateTimekitProject;
use Laravel\Nova\Fields\Boolean;
class Project extends Resource
{
 public static $group = 'Settings';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Project';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'Name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'description',
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

            HasMany::make('managers'),

            Text::make('Name')
            ->rules('required'),

            Text::make('Slug')
            ->rules('required'),

            Text::make('Description')
            ->rules('required'),

            Text::make('Length (Minutes)', "length")
            ->rules('required'),

            Text::make('Buffer (Minutes)', 'buffer')
            ->rules('required'),

            Text::make('Time Kit Resource', 'timekit_project_id')
                ->rules('required')
                ->withMeta([
                    'extraAttributes' => [
                        'placeholder' => config('constants.timekit.default_timekit_resource_id')
                    ],
                    'value' => config('constants.timekit.default_timekit_resource_id')
                ]),
        Text::make('Mobile Name', 'mobile_name')
            ->rules('required'),          
     Boolean::make('Default Value','default')
        ->trueValue('1')
        ->falseValue('0'),
            HasMany::make('managers'),

            HasMany::make('Project Pricings')
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
        return [
            new CreateTimekitProject
        ];
    }
}
