<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Locationtype;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    //
    protected $guarded=[];
    protected $casts = [
        'cashonly' => 'boolean',
    ];
    use SoftDeletes;
      protected $dates = ['deleted_at'];
  

    public function services(){
 		return $this->hasMany(Service::class);

    }
public function avgReviews($id){


         return DB::select(DB::raw( "select round(avg(review_score),1) as avgreview,count(*) as number_reviews  from reviews r, transactions t
where t.location_id=:id and r.transaction_id=t.id"),array('id'=>$id ));
 

    }
public function locationpercentages(){
    return $this->hasMany(Locationpercentages::class,'location_id','id');

    }
   public function countServices() 
	{
    return $this->services()->withTrashed()->count();
	}


  public function countTransactions() 
  {
      return $this->transactions()->count();
  }
 public function countLocationpercentages() 
  {
    return $this->Locationpercentages()->count();
  }
  

	public function locationtypes()
	{
		return $this->belongsToMany(Locationtype::class);
	}
  public function employees(){
    return $this->hasMany(Employee::class,'location_id','id');

    }

    public function employeesWithTrashed(){
    return $this->employees()->withTrashed();

    }
  public function countEmployees()
  {
     return $this->employees()->withTrashed()->count();
  }

  public function dayschedule(){
    return $this->hasMany(Dayschedule::class,'location_id','id');

  }

   public function dayscheduleFuture(){
    return $this->dayschedule()->future();

  }
   public function dayscheduleWithTrashed(){
    return $this->dayschedule()->withTrashed();

    }

      public function timings(){
            return $this->hasMany(Timings::class,'location_id','id');
    }


  public function transactions(){
    return $this->hasMany(Transactions::class,'location_id','id');
  }  

   public function getlasttransactions(){
    return $this->transactions()->orderBy('created_at', 'desc');
  } 

  public function acceptedTransactions()
  {
    return $this->transactions()->accepted();
  }
 

  public function oldTransactionsInitaltwo()
  {
    return $this->transactions()->accepted()->oldinitialtwo();
  }
 public function oldTransactionsInital()
  {
    return $this->transactions()->accepted();
  }
   public function oldTransactionsFiltered()
  {
    return $this->transactions()->accepted()->old();
  }
  public function currentTransactions()
  {

    return $this->transactions()->accepted()->current();
  }



    public function getCashonlyAttribute($value)
    {

      
      if( $value==1){
            return  true;
        }
        else{
            return  false;
        }
        
        
        
    }


    public function setCashonlyAttribute($value)
    {
      if($value==true){
      $this->attributes['cashonly'] = 1;
    }
    else{
      $this->attributes['cashonly'] = 0;
    }
    }


}
