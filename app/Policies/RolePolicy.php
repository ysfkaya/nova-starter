<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(Admin $user): bool
    {
        return $user->hasAnyPermission(['view role', 'create role', 'update role', 'delete role']);
    }

    public function view(Admin $user, Role $role): bool
    {
        return ! in_array($role->name, Role::IGNORE_ROLES) && $user->hasPermissionTo('view role');
    }

    public function create(Admin $user): bool
    {
        return $user->hasPermissionTo('create role');
    }

    public function update(Admin $user, Role $role): bool
    {
        return ! in_array($role->name, Role::IGNORE_ROLES) && $user->hasPermissionTo('update role');
    }

    public function delete(Admin $user, Role $role): bool
    {
        return ! in_array($role->name, Role::IGNORE_ROLES) && $user->hasPermissionTo('delete role');
    }
}
