<?php

namespace App\Policies;

use App\User;
use App\Review;
use App\Transactions;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;
class ReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

     public function create(User $user,Review $review, Transactions $transaction)
    { Log::error(' Review Policy');
        return $user->id === $transaction->user_id;
    }
}
