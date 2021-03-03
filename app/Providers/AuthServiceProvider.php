<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Role;
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

        Gate::before(function ($user, $ability, $arguments) {
            $model = head($arguments);

            return $model == Permission::class ? false : ($user->hasAnyRole(Role::IGNORE_ROLES) ? true : null);
        });

        Gate::policy(config('permission.models.role'), RolePolicy::class);
        Gate::policy(config('permission.models.permission'), RolePolicy::class);
    }
}
