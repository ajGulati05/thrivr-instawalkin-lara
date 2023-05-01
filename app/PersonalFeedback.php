<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalFeedback extends Model
{

	protected $table='personal_feedbacks';
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_comment', 'manager_reply'
    ];
}
