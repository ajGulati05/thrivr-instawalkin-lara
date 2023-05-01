<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;

use Laravel\Nova\Filters\DateFilter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class BookingEndDatesFilter extends DateFilter
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
        $to = Carbon::parse($value)->endOfDay();
            
        return $query->where('start','<=',$to);
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
