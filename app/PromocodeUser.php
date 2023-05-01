<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PromocodeUser extends Model
{
    //
    protected $primaryKey = ['user_id', 'promocode_id'];
public $incrementing = false;
    protected $table="promocode_user";
    protected $guarded=[];
    public $timestamps=false;



 protected function setKeysForSaveQuery(Builder $query)
    {
        return $query->where('user_id', $this->getAttribute('user_id'))
            ->where('promocode_id', $this->getAttribute('promocode_id'));
    }



}
