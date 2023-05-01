<?php

namespace App\Providers;

use App\Nova\Cards\BookingInsights;
use App\Nova\Cards\RevenueInsights;
use Laravel\Nova\Nova;
use Laravel\Nova\Cards\Help;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Admin;
use Coroowicaksono\ChartJsIntegration\StackedChart;
use App\Http\Controllers\NovaAuth\CustomResetPasswordController;
use Laravel\Nova\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\NovaAuth\CustomForgotPasswordController;
use Laravel\Nova\Http\Controllers\ForgotPasswordController;

use App\Nova\Cards\UserInsights;
class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, Admin::pluck('email')->all());
        });
    }

    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            (new UserInsights)->render(),
            (new BookingInsights)->render(),
            (new RevenueInsights)->render()
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {    $this->app->bind(ForgotPasswordController::class, CustomForgotPasswordController::class);
         $this->app->bind(ResetPasswordController::class, CustomResetPasswordController::class);
          Nova::sortResourcesBy(function ($resource) {
            return $resource::$priority ?? 99999;
        });
    }
/**
 * Get the extra dashboards that should be displayed on the Nova dashboard.
 *
 * @return array
 */
protected function dashboards()
{
    return [

    ];
}

}
