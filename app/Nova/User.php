<?php

namespace App\Nova;

use App\Nova\Actions\UserKPIReport;
use App\Nova\Filters\CreatedAtEndDateFilter;
use App\Nova\Filters\CreatedAtStartDateFilter;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class User extends Resource
{
    public static $group = 'Users';
    public static $priority = 1;
    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['userprofiles'];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'email',
    ];

    /**
     * The relationship columns that should be searched.
     *
     * @var array
     */
    public static $searchRelations = [
        'userprofiles' => ['firstname','lastname',],
    ];

    /**
     * The relationship columns that should to be concatenated and searched.
     *
     * @var array
     */
    public static $searchRelationsConcatenation = [
        'userprofiles' => [
            ['firstname', 'lastname'],
        ],
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

            Text::make('User',function () { return $this->profiles->firstname.' '.$this->profiles->lastname; })->onlyOnIndex(),
            Text::make('Last Booking',function () { return optional($this->latestBooking())->start; })->onlyOnIndex(),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Text::make('Provider','provider')
                ->sortable(),

            HasOne::make('Profile', 'profiles','App\Nova\UserProfile'),
            HasMany::make('Guest', 'userGuests','App\Nova\UserGuest'),
            HasMany::make('Bookings', 'books','App\Nova\Booking')


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
        return [new CreatedAtStartDateFilter(), new CreatedAtEndDateFilter()];
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
            new UserKPIReport
        ];
    }
    public static function authorizable()
    {
        return false;
    }
}
