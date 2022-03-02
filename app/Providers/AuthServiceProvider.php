<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Permission;
use App\Policies\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before($this->beforeGateCallback());

        Gate::policy(config('permission.models.role'), RolePolicy::class);
        Gate::policy(config('permission.models.permission'), RolePolicy::class);
    }

    /**
     * @return \Closure
     */
    private function beforeGateCallback()
    {
        return function ($user, $ability, $arguments) {
            $model = head($arguments);

            if ($model == Permission::class || $model instanceof Permission) {
                return false;
            }

            if ($model instanceof Page && $ability == 'delete') {
                return null;
            }

            return $user->isSuper() ? true : null;
        };
    }
}
