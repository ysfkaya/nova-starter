<?php

namespace App\Policies;

use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny($user): bool
    {
        return $user->hasAnyPermission(['view role', 'create role', 'update role', 'delete role']);
    }

    public function view($user, Role $role): bool
    {
        return !in_array($role->name, Role::IGNORE_ROLES) && $user->hasPermissionTo('view role');
    }

    public function create($user): bool
    {
        return $user->hasPermissionTo('create role');
    }

    public function update($user, Role $role): bool
    {
        return !in_array($role->name, Role::IGNORE_ROLES) && $user->hasPermissionTo('update role');
    }

    public function delete($user, Role $role): bool
    {
        return !in_array($role->name, Role::IGNORE_ROLES) && $user->hasPermissionTo('delete role');
    }
}
