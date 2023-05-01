<?php

namespace App\Nova;

use Illuminate\Http\Request;

use Laravel\Nova\Fields\ID;

use Laravel\Nova\Http\Requests\NovaRequest;

use Laravel\Nova\Fields\Text;

use Laravel\Nova\Fields\Boolean;

use Laravel\Nova\Fields\HasMany;

use Laravel\Nova\Fields\Number;

class SubModalitie extends Resource

{

    /**

     * The model the resource corresponds to.

     *

     * @var string

     */

    public static $model = \App\SubModalitie::class;

    /**

     * The single value that should be used to represent the resource when being displayed.

     *

     * @var string

     */

    public static $title = 'description';

    /**

     * The columns that should be searched.

     *

     * @var array

     */

    public static $search = [

        'code',

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

            Text::make('code')

                ->sortable()

                ->rules('required', 'string', 'max:4')

                ->creationRules('unique:sub_modalities,code')

                ->updateRules('unique:sub_modalities,code'),

             Text::make('Description')

                ->sortable()

                ->rules('required', 'string', 'max:254'),

           Number::make('Minutes')->min(0)->max(60)->step(15),

            Boolean::make('Active','active')

                    ->withMeta(['value' => $this->active ?? true]),

              Boolean::make('Admin Panel Only','only_admin_panel')

                    ->trueValue('1')

                    ->falseValue('0'),    

             HasMany::make('Sub Modality Pricings', 'subModalitiesPricings','App\Nova\SubmodalitiesPricing')

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