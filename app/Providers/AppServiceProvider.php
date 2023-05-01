<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Auth;
use App\Project;
use App\Observers\ProjectObserver;

use App\Userprofile;
use App\Observers\UserProfilesObserver;

use App\ManagerLicense;
use App\Observers\ManagerLicenseObserver;
use App\Booking;
use App\Observers\BookingObserver;
use App\Observers\ProjectPricingObserver;
use App\ProjectPricing;
use App\Manager;
use App\Observers\ManagerObserver;
use App\ManagerProject;
use App\Observers\ManagerProjectObserver;

use App\User;
use App\Observers\UserObserver;
use App\Resolvers\SocialUserResolver;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Receipt;
use App\Observers\ReceiptObserver;

use App\IntakeForm;
use App\Observers\IntakeFormObserver;
use App\CovidForm;
use App\Observers\CovidFormObserver;
use App\ManagerProfile;
use App\Observers\ManagerProfileObserver;

use App\Helpers\PendingConcurrentPool;

use App\RewardEmail;
use App\Observers\RewardEmailObserver;
use Closure;
class AppServiceProvider extends ServiceProvider
{

    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        SocialUserResolverInterface::class => SocialUserResolver::class,
    ];
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

      User::observe(UserObserver::class);
      Project::observe(ProjectObserver::class);
      ManagerLicense::observe(ManagerLicenseObserver::class);
      Manager::observe(ManagerObserver::class);
      IntakeForm::observe(IntakeFormObserver::class);
      CovidForm::observe(CovidFormObserver::class);
      ManagerProfile::observe(ManagerProfileObserver::class);

      Booking::observe(BookingObserver::class);
       Userprofile::observe(UserProfilesObserver::class);

        //ManagerProject::observe(ManagerProjectObserver::class);
        //ProjectPricing::observe(ProjectPricingObserver::class);
RewardEmail::observe(RewardEmailObserver::class);
        Schema::defaultStringLength(191);

        /**
         * Paginate a standard Laravel Collection.
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });


PendingRequest::macro('pool', function (Closure $requestsBuilder) {
    return new PendingConcurrentPool($requestsBuilder);
});
     
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
