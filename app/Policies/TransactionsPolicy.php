<?php

namespace App\Policies;

use App\User;

use App\Review;
use App\Transactions;
use Illuminate\Support\Facades\Log;
class TransactionsPolicy
{


public function create(User $user, Transactions $transaction,Review $review)
    { Log::error(' Review Polic2y');
        return $user->id === $transaction->user_id;
    }
}
