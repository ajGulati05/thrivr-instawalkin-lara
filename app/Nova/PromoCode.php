<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Boolean;
use R64\NovaFields\JSON;
use Laravel\Nova\Fields\Number;
class PromoCode extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Gabievi\Promocodes\Models\Promocode::class;

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
            ID::make(__('ID'), 'id')->sortable(),
               Text::make('Code')
                ->sortable(),
                JSON::make('Data', [
                             Boolean::make('Monthly'),
                            Text::make('Description'),
                            Text::make('Currency')
                    ], 'data'),
                Number::make('Reward'),
                Date::make('expires_at'),
                Boolean::make('is_disposable'),

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

/*Promocodes::create($amount = 1, $reward = null, array $data = [], $expires_in = null, $quantity = null, $is_disposable = false);

If you want to create code that will be used only once, here is method for you.

Promocodes::createDisposable($amount = 1, $reward = null, array $data = [], $expires_in = null, $quantity = null);*/
