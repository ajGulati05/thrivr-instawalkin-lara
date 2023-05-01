<?php

namespace App\Observers;

use App\Booking;
use App\RewardHistory;
use App\UserReward;
use Illuminate\Http\Request;
use App\Manager;
use App\User;
use App\Notifications\UserBookingNotification;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Notifications\UserStatusChangeBookingNotification;
use App\Notifications\IntakeFormReminderNotification;
use App\Notifications\ManagerStatusChangeBookingNotification;
use App\Http\Traits\v2\TimekitTraitV2;
use Exception;
use App\Notifications\BookAMassageReminderNotification;
use App\Receipt;
use App\Notifications\ReceiptNotification;
use Thomasjohnkane\Snooze\ScheduledNotification;
use App\Helpers\PromoCodeClass;
use App\Helpers\ReferralRewardClass;

class BookingObserver
{

    use TimekitTraitV2;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the booking "created" event.
     *
     * @param \App\Booking $booking
     * @return void
     */
    public function created(Booking $booking)
    {

        $user = $booking->bookable;
        if ($booking->bookable_type == 'App\User') {
            $manager = $booking->manager;

            if (!$manager->clients->contains($user)) {
                $manager->clients()->syncWithoutDetaching($user);
            }


        }
        try {

            if (Carbon::parse($booking->start)->diffInHours(Carbon::now()) < 24) {
                $user->notifyAt(new UserBookingNotification($booking, 1), Carbon::parse($booking->start)->addMinutes(-60));

            } else {
             $user->notifyAt(new UserBookingNotification($booking, 1), Carbon::parse($booking->start)->addDays(-1));
             $user->notifyAt(new IntakeFormReminderNotification($booking), Carbon::parse($booking->start)->addHours(-2));

            }
            $scheduledNotifications = ScheduledNotification::findByTarget($booking->bookable);

            foreach ($scheduledNotifications as $scheduledNotification) {

                if ($scheduledNotification->getType() == 'App\Notifications\BookAMassageReminderNotification' && !$scheduledNotification->isCancelled() && !$scheduledNotification->isSent()) {
                    $scheduledNotification->cancel();
                }

            }

            $user->notifyAt(new BookAMassageReminderNotification(), Carbon::parse($booking->start)->addDays(30));


            // Instantiate a receipt with supporting booking details
            // Log::debug('In BookingObserver... ');
            // Log::debug('source booking: ' . $booking);
            // Log::debug('source booking id: ' . $booking->id);

            $receiptDate = Carbon::parse($booking->end)->addMinutes(5);                                     //->toDateTimeString();

            $receipt = Receipt::create([
                "booking_id" => $booking->id,
                "request_date" => $receiptDate->toDateTimeString(),
                "requested_by" => 'System',
                "requested_by_id" => 0,
                "duplicated" => false
            ]);

            // Schedule a receipt for just past end of booking. Manager has entire booking to
            // decide to cancel or reschedule the customer's booking. Receipt process must check
            // if receipt is still required (via booking details).
            $user->notifyAt(new ReceiptNotification($receipt), $receiptDate);                               //Carbon::parse($booking->end)->addMinutes(5));

        } catch (\Exception $e) { // Using a generic exception
            Log::debug('Scheduled booking issue' . $e);
            Log::critical('Scheduled booking issue' . $booking->id);
        }

    }

    /**
     * Handle the booking "updated" event.
     *
     * @param \App\Booking $booking
     * @return void
     */
    public function updated(Booking $booking)
    {

        if ($booking->booking_status == Booking::CANCELLED_BOOKING_STATUS || $booking->booking_status == Booking::RESCHEDULED_BOOKING_STATUS) {

            $this->cancelBookingTimekit($booking->timekit_booking_id);
            try {

                $booking->bookable->notify(new UserStatusChangeBookingNotification($booking));
                $booking->manager->notify(new ManagerStatusChangeBookingNotification($booking));
            } catch (\Exception $e) { // Using a generic exception
                Log::critical('Booking status change notification error' . $booking->id);
            }


        }

    if($booking->closed) {
        Log::debug("Call");
        $this->syncRewardsAndPromoCodes($booking);
    }

        //ADD PAID BY EVENTS

    }

    /** if the  booking is cancelled, re-scheduled or deleted the rewards and promo codes should be voided.
     * So they can be applied again. If the booking progresses as normal - the person who made the referral should get a reward.
     * @param Booking $booking
     */
    public function syncRewardsAndPromoCodes(Booking $booking)
    {

        if ($booking->booking_status == Booking::CANCELLED_BOOKING_STATUS || $booking->booking_status == Booking::RESCHEDULED_BOOKING_STATUS ||
            $booking->booking_status == Booking::DELETED_BOOKING_STATUS) {
            $this->voidRewardsAndPromoCodes($booking);
        } else {
            $this->awardRewards($booking);
        }

    }

    public function awardRewards(Booking $booking)
    {


        $user=$booking->bookable;



            //$rewardee=user that invited the user that made the booking($user)
            $rewardee=$user->rewardee;

if($user && $rewardee){
    //The reason why rewardee and user are flipped is because the user is not the one getting the reward now its the rewardee.
    //rewardee is the one who should be rewarding the other user  back
    if( RewardHistory::where([
        ['rewardee_id',$user->id],
        ['user_id',$rewardee->id],
        ['pending',true]])->exists()) {
        Log::debug("setting pending to false");

        //change pending to true if it exists
        $rewardHistory=RewardHistory::where([
            ['rewardee_id',$user->id],
            ['user_id',$rewardee->id],
            ['pending',true]])->first();
        $rewardHistory->pending=false;
        $rewardHistory->save();



        //this can be moved to an observer for rewardhistory

        $rewardHelper = new ReferralRewardClass;
        $rewardHelper->apply($rewardee, UserReward::REWARDEE_REWARD);
    }
}


    }

    //TODO if a booking is cancelled or rescheduled return the promo and discount
    public function voidRewardsAndPromoCodes(Booking $booking)
    {

    }
}
