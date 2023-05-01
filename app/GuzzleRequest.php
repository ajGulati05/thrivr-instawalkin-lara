<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuzzleRequest extends Model
{
  protected $fillable=[
    'url','body','username_auth','key_auth'
  ];
}
