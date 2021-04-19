<?php

namespace App\Providers;

use App\Models\Admin;
use App\Nova\Metrics\NewUser;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Mirovit\NovaNotifications\NovaNotifications;
use Davidpiesse\NovaMaintenanceMode\Tool as Maintance;
use Illuminate\Http\Resources\MissingValue;
use Ysfkaya\Settings\SettingTool;

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
            return $user instanceof Admin;
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        $hasAnalytics = setting('analytics.view_id') && !empty(setting('analytics.credentials'));

        $analyticCards = $this->_when($hasAnalytics, function () {
            return [
                new \Tightenco\NovaGoogleAnalytics\ActiveUsers,
                new \Tightenco\NovaGoogleAnalytics\PageViewsMetric,
                new \Tightenco\NovaGoogleAnalytics\VisitorsMetric,
                // new \Tightenco\NovaGoogleAnalytics\ReferrersList,
                new \Tightenco\NovaGoogleAnalytics\TopBrowsers,
                new \Tightenco\NovaGoogleAnalytics\MostVisitedPagesCard,
            ];
        }, []);


        return array_merge([
            NewUser::make()->canSeeWhen('view user'),
        ], $analyticCards);

        return [];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            Maintance::make()->canSee(function ($request) {
                return $request->user()->isSuper();
            }),

            SettingTool::make(),
            NovaNotifications::make()
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    protected function _when($condition, $value, $default = null)
    {
        if ($condition) {
            return value($value);
        }

        return func_num_args() === 3 ? value($default) : new MissingValue;
    }
}
