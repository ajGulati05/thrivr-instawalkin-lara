<?php

/*
 * This file is part of questocat/laravel-referral package.
 *
 * (c) questocat <zhengchaopu@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Traits\v2;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Request;
use Illuminate\Support\Facades\Log;
trait UserReferralTrait
{
    public function getReferralLink()
    {
        return url('/').'/?ref='.$this->affiliate_id;
    }

    public static function scopeReferralExists(Builder $query, $referral)
    {
        return $query->whereAffiliateId($referral)->exists();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Request::exists('referral')) {
                if(static::referralExists(Request::input('referral')))

                {
                        $model->referred_by = Request::input('referral');

                }
            }
         
        });
      
    }




    protected static function generateReferral($model)
    {


    $firstName = strtoupper(substr($model->firstNameValue,0,2));
    $lastName = strtoupper(substr($model->lastNameValue,0,2));

    $affiliate_id = $firstName . $lastName;

    $i = 0;
  
    do  {
        $i++;
        $affiliate_id = $firstName . $lastName . $i;
    }  while(static::referralExists($affiliate_id));

   $model->affiliate_id=$affiliate_id;
   $model->save();
    }
}