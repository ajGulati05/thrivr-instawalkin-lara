<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RmtTeam extends Model
{
    //
/**
 * Get the route key for the model.
 *
 * @return string
 */
public function getRouteKeyName()
{
    return 'slug';
}

    public function managers(){

    	    return $this->belongsToMany('App\Manager','managerrmtteams','rmt_team_id');
    }


    public function activeManagers(){
    	return $this->managers()->active();
    }
}
