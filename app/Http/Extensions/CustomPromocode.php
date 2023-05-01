<?php

namespace App\Http\Extensions;

use Promocodes;
use Carbon\Carbon;
use App\Exceptions\SecondUsageInAMonthException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class CustomPromocode extends Promocodes
{

   /**
     * Check if user is trying to apply code again.
     *
     * @param Promocode $promocode
     *
     * @return bool
     */
    public function isSecondUsageInAMonthAttempt(Promocode $promocode)
    {
        $firstDayofPreviousMonth = Carbon::now()->startOfMonth();
        $lastDayofPreviousMonth = Carbon::now()->endOfMonth();

        $doesExist= $promocode->users()
            ->wherePivot(config('promocodes.related_pivot_key', 'user_id'),
            auth()->id())
            ->exists();

            if($doesExist){
                 throw new SecondUsageInAMonthException;
            }

            return $doesExist;
    }



  


}
 