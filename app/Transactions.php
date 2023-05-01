<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transactions extends Model
{
    //

    protected $fillable = [];
    protected $casts = [
        'transactionclosed' => 'boolean',
        'read' => 'boolean'
    ];



    public function reviews()
    {
        return $this->hasOne(Review::class, 'transaction_id', 'id');
    }


    public function scopeFilter($query, $filters)
    {
        if ($month = $filters['month']) {
            $query->whereMonth('created_at', Carbon::parse($month)->month);
        }
        if ($day = $filters['day']) {
            $query->whereDay('created_at', $day);
        }

        if ($year = $filters['year']) {
            $query->whereYear('created_at', $year);
        }
    }

    public function scopeFilterold($query, $filters)
    {

        if ($month = $filters['month']) {
            $query->whereMonth('created_at', Carbon::parse($month)->month);
        }
        if ($day = $filters['day']) {
            $query->whereDay('created_at', '<=', $day);
        }

        if ($year = $filters['year']) {
            $query->whereYear('created_at', $year);
        }
    }

    public function scopeFilteroldinitaltwo($query, $filters)
    {


        if ($startdate = $filters['startdate']) {
            $enddate = $filters['enddate'];
            $query->whereBetween('created_at', [$startdate, $enddate]);
        }
    }

    public function scopeFilteroldinital($query, $filters)
    {

        if ($startmonth = $filters['month']) {
            $query->whereMonth('created_at', Carbon::parse($startmonth)->month);
        }
        if ($day = $filters['day']) {
            if ($day > 15) {
                $query->whereDay('created_at', '>', 15);
            } else {
                $query->whereDay('created_at', '<=', 15);
            }
        }

        if ($year = $filters['year']) {
            $query->whereYear('created_at', $year);
        }
    }

    public static function managerHistoryWebBiWeekly($id)
    {

        return collect(DB::select(DB::raw("select count(*) as countvalue, year(b.start_week) as startyear, monthname(b.start_week) as startmonthname, year(b.end_week) as endyear, monthname(b.end_week) as endmonthname, day(b.start_week) as startdate, day(b.end_week) as enddate,min(b.start_week) as rowID ,min(b.end_week) as enddateval  from transactions t, biweeklys b 
where (t.created_at between b.start_week and b.end_week) and t.location_id=:id
group by startyear,startmonthname,endyear,endmonthname,enddate,startdate
order by min(t.created_at) desc "), array('id' => $id)));
    }


    public static function managerHistoryWeb($id)
    {
        return static::select(DB::raw(' year(transactions.created_at) as year,monthname(transactions.created_at) as monthname, IF(day(transactions.created_at) <=15, "(Week 1-2)", "(Week 2-4)")as weekType,min(created_at) as rowID'))
            ->where('location_id', $id)
            ->groupBy('year', 'monthname', 'weekType')
            ->orderByRaw('min(created_at) desc')
            ->get();
    }

    public static function managerHistoryApi()
    {
        return static::selectRaw('year(created_at) year, monthname(created_at) month, count(*) transactions')
            ->groupyBy('year', 'month')
            ->orderByRaw('min(created_at) desc')
            ->get()
            ->toJson();
    }



    public static function userHistoryApi()
    {
        return static::selectRaw('year(created_at) year, monthname(created_at) month, count(*) transactions')
            ->groupyBy('year', 'month')
            ->orderByRaw('min(created_at) desc')
            ->get()
            ->toJson();
    }

    public function locations()
    {
        return $this->hasOne(Location::class, 'id', 'location_id')->withTrashed();
    }
    public function locationpercentages()
    {
        return $this->hasOne(Locationpercentages::class, 'location_id', 'location_id');
    }
    //wrong
    public function services()
    {
        return $this->hasOne(Service::class, 'id', 'service_id')->withTrashed();;
    }
    //correct
    public function servicecategories()
    {
        return $this->hasOne(Servicecategory::class, 'id', 'servicecategory_id')->withTrashed();;
    }
    public function users()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function userprofiles()
    {
        return $this->hasOne(Userprofile::class, 'user_id', 'user_id');
    }

    public function serviceresponse()
    {
        return $this->hasOne(ServiceResponse::class, 'code', 'service_response_code');
    }

    public function employees()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function scopeAccepted($query)
    {
        return $query->where('service_response_code', '=', 'A')->orderByDesc('created_at');
    }
    public function scopeRecent($query)
    {
        //created_at is today 
        //time is less than 60 minutes
        return $query->where('id', '=', '458');
    }
    public function scopeCurrent($query)
    {
        return $query->filter(request(['day', 'month', 'year']));
    }

    public function scopeOld($query)
    {
        return $query->filterold(request(['day', 'month', 'year']));
    }
    public function scopeOldinitial($query)
    {
        return $query->filteroldinital(request(['day', 'month', 'year']));
    }

    public function scopeOldinitialtwo($query)
    {
        return $query->filteroldinitaltwo(request(['startdate', 'enddate']));
    }

    public function getAfterstatusAttribute($value)
    {
        if ($value == "N") {
            return true;
        }
        return false;
    }

    public function getTransactionclosedAttribute($value)
    {


        if ($value == 1) {
            return  true;
        } else {
            return  false;
        }
    }

    public function credithistorys()
    {
        return $this->hasOne(Credithistorys::class, 'transaction_id', 'id');
    }


    public function promocodehistorys()
    {
        return $this->hasOne(Promocodehistory::class, 'transaction_id', 'id');
    }


    public function getReadAttribute($value)
    {

        if ($value == 1) {
            return  true;
        } else {
            return  false;
        }
    }


    public function setReadAttribute($value)
    {


        if ($value == true) {
            $this->attributes['read'] = 1;
        } else {
            $this->attributes['read'] = 0;
        }
    }

    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }
}
