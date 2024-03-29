<?php

namespace App\Providers;

use App\Models\Admin;
use App\Nova\Metrics\NewUser;
use Davidpiesse\NovaMaintenanceMode\Tool as Maintance;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Mirovit\NovaNotifications\NovaNotifications;
use Spatie\BackupTool\BackupTool;
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

        $prefix = Nova::path().'/filemanager';

        Route::middleware(config('nova.middleware', []))
            ->domain(config('nova.domain', null))
            ->prefix($prefix)
            ->group(function () {
                \UniSharp\LaravelFilemanager\Lfm::routes();
            });
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
        return array_merge([
            NewUser::make()->canSeeWhen('view user'),
        ], $this->analyticCards());
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

            BackupTool::make()->canSeeWhen('viewBackups', Admin::class),
            SettingTool::make()->canSeeWhen('viewSettings', Admin::class),
            NovaNotifications::make(),
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

    /**
     * @param bool $condition
     * @param mixed $value
     * @param mixed $default
     *
     * @return mixed
     */
    private function _when($condition, $value, $default = null)
    {
        if ($condition) {
            return value($value);
        }

        return func_num_args() === 3 ? value($default) : new MissingValue;
    }

    /**
     * @return array
     */
    private function analyticCards()
    {
        $credentials = config('analytics.credentials');

        $hasAnalytics = ! empty(config('analytics.view_id')) && ((is_file($credentials) && file_exists($credentials)) || is_array($credentials));

        return $this->_when($hasAnalytics, function () {
            return [
                new \Tightenco\NovaGoogleAnalytics\ActiveUsers,
                new \Tightenco\NovaGoogleAnalytics\PageViewsMetric,
                new \Tightenco\NovaGoogleAnalytics\VisitorsMetric,
                new \Tightenco\NovaGoogleAnalytics\ReferrersList,
                new \Tightenco\NovaGoogleAnalytics\TopBrowsers,
                new \Tightenco\NovaGoogleAnalytics\TopCountries,
                new \Tightenco\NovaGoogleAnalytics\MostVisitedPagesCard,
            ];
        }, []);
    }
}
