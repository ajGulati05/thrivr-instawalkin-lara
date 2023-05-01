<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;


class ManagerProject extends Pivot
{
    protected $table = 'managers_projects';

}
