<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;

class RouteServiceProvider extends ServiceProvider
{

/**
 * The path to the "home" route for your application.
 *
 * @var string
 */
public const HOME = '/home';

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {

        //thes routes are only available on staging and dev
        if(!App::environment('production'))
        {
         $this->mapTestingRoutes();
        }
        //these routes were default
        $this->mapApiRoutes();
        $this->mapWebRoutes();

        //Custom routes
          $this->mapUsersapiRoutes();
         $this->mapTherapistBackendRoutes();
         $this->mapCovidBackEndRoutes();

         //Custom V2 routes
          $this->mapUsersapiV2Routes();
        //$this->mapManagerRoutes();
       // $this->mapUserRoutes();
        //$this->mapAdminRoutes();
        //$this->mapMangersapiRoutes();
    
       // $this->mapIndividualWebsiteRoutes();
       $this->mapSocialRoutes();
       
    }
  

        /**
     * This is the current version of the managers routes
     */
    protected function mapTestingRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
            ->group(base_path('routes/dev.php'));
    }
   
        /**
     * This is the current version of the managers routes
     */
    protected function mapUsersapiV2Routes()
    {
        Route::middleware('api')
            ->prefix('usersapi')
            ->namespace($this->namespace)
            ->group(base_path('routes/usersapi/v2/usersapi.php'));
    }

      /**
     * This is the current version of the managers routes
     */
    protected function mapUsersapiRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/usersapi.php'));
    }

  

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }


protected function mapTherapistBackendRoutes()
    {
        Route::middleware('api')
            ->prefix('therapist')
            ->namespace($this->namespace)
            ->group(base_path('routes/therapistbackend.php'));
    }


protected function mapCovidBackEndRoutes()
    {
        Route::namespace($this->namespace)
            ->group(base_path('routes/support.php'));
    }

    protected function mapSocialRoutes(){
        Route::middleware('api')
        ->prefix('social')
        ->namespace($this->namespace)
        ->group(base_path('routes/social.php'));
    }
}
/* protected function mapAdminRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
    }

    protected function mapUserRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/user.php'));
    }


    protected function mapMangersapiRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/managersapi.php'));
    }


    protected function mapManagerRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/manager.php'));
    }


protected function mapIndividualWebsiteRoutes()
    {
        Route::prefix('therapistwebsite')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/therapistwebsite.php'));
    }*/