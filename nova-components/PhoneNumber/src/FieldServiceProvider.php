<?php

namespace Dniccum\PhoneNumber;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('tel-input', public_path('assets/plugin/intltelinput/js/intlTelInput.min.js'));
            Nova::style('tel-input', public_path('assets/plugin/intltelinput/css/intlTelInput.min.css'));
            Nova::script('phone-number', __DIR__ . '/../dist/js/field.js');
            Nova::style('phone-number', __DIR__ . '/../dist/css/field.css');
        });
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
}
