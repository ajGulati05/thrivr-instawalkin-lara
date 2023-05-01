<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;

use Laravel\Nova\Filters\DateFilter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class CreatedAtEndDateFilter extends DateFilter
{


    public $name="End Date";
    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        $from = Carbon::parse($value)->endOfDay();

        return $query->where('created_at','<=',$from);
    }
    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [];
    }

}
