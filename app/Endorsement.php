<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Manager;
class Endorsement extends Model
{
     public function reviews()
    {
        return $this->belongsToMany('App\Review');
    }


      public static function endorsementCountForUsers(Manager $manager)
    {
    
    	
    	$endorsementsCount  = DB::select('select endorsement_id,  sum(endorsementCount) as endorsementSum from (select er.endorsement_id,count(*) as endorsementCount from endorsement_review er, reviews r, managers m where r.id=er.review_id and m.id=r.manager_id and verified=1 and manager_id=? group by er.endorsement_id
union
select er.endorsement_id,1 as endorsementCount from endorsement_review er, reviews r, managers m where r.id=er.review_id and m.id=r.manager_id and verified=0 and manager_id=? group by er.endorsement_id) x group by endorsement_id
', [$manager->id,$manager->id]);
       

       return $endorsementsCount;
    }


}
