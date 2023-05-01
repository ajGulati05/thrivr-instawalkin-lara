<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Password;
use App\Gender;
use Laravel\Nova\Fields\Select;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\HasMany;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Image;
use App\Product;
use Laravel\Nova\Fields\Timezone;
class Manager extends Resource
{

    public static $group = 'Therapists';
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Manager';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'email';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'email', 'password', 'first_name', 'last_name',
    ];

    /**
     * The columns that should be concatenated and searched.
     *
     * @var array
     */
    public static $searchConcatenation = [
        ['first_name', 'last_name'],
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

            Text::make('First Name','first_name')
                ->sortable()
                ->rules('required', 'string', 'max:254'),

            Text::make('Last Name')
                ->sortable()
                ->rules('required', 'string', 'max:254'),
            Timezone::make('Timezone'),
            Text::make('Business Name')
                ->sortable()
                ->rules('required', 'string', 'max:254'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}')
                ->hideWhenUpdating(),


            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            Select::make('gender')
                ->options([
                    'M' => Gender::where('code', 'M')->first()->description,
                    'F' => Gender::where('code', 'F')->first()->description,
                ])
                ->rules('required'),
            Select::make('Product','product_code')->options(Product::pluck('description','code'))->displayUsingLabels(),
            // ->displayUsingLabels(),
            Boolean::make('Status','status')
                ->trueValue('1')
                ->falseValue('0'),

            Image::make('Profile Photo')->disk('s3')->path('managers')->disableDownload()->maxWidth(100),
            HasOne::make('Manager Profile','profiles')->rules('required'),
            HasOne::make('Manager Notifications','managernotifications')->rules('required'),
            HasMany::make('Manager Licenses','manager_licenses')->rules('required'),
            BelongsToMany::make('projects')->rules('required'),



            BelongsToMany::make('Manager Specialities', 'manager_specialities')
                ->rules('required'),
            BelongsToMany::make('Secondary Emails','secondary_emails'),
            BelongsToMany::make('RMT Team','rmt_teams'),
            HasMany::make('Bookings','bookings'),

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
        return [
            new Lenses\TherapistsByCity,
        ];
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
        return 'Therapists';
    }
    /**
     * Determine if the given resource is authorizable.
     *
     * @return bool
     */
    public static function authorizable()
    {
        return false;
    }
}
