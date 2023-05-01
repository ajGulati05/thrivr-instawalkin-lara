<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Service;
use App\Employee;
use Carbon\Carbon;
class Dayschedule extends Model
{
   	protected $guarded=[];
    use SoftDeletes;
    protected $dates = ['deleted_at'];

       public function services(){
        return $this->belongsTo(Service::class,'service_id','id');

    }

       public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');

    }


     public function scopeFuture($query)
    {
        return $query->where('scheduledtime', '>', Carbon::now());
    }
}
