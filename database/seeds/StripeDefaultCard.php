<?php

use App\Http\Traits\v2\StripeTraitV2;
use App\User;
use Illuminate\Database\Seeder;

class StripeDefaultCard extends Seeder
{
    use StripeTraitV2;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        // Get all users that have add a credit card
        $users = User::whereHas('stripedata')->get();

        foreach ($users as $user) {
            // Get the current default card of the user
            $defaultCard = $user->stripedata()->where('default_card',true)->orderBy('updated_at','desc')->first();
          
            try {
                if($defaultCard){
                    // Update stripe's default payment id 
                    $this->_update($defaultCard->stripe_id,['default_source'=>$defaultCard->card_token]);
                }
              
            } catch (\Throwable $th) {
                //throw $th;
            }
            

        }
    }
}
