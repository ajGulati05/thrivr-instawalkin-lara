<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CTARecord extends Model
{
	use SoftDeletes;
    //
     protected $guarded=[];
}
