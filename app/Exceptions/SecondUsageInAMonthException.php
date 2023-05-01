<?php

namespace App\Exceptions;

use Exception;

class SecondUsageInAMonthException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'uh Oh! Looks like you have already used this promotion this month already.';

    /**
     * @var int
     */
    protected $code = 403;
}