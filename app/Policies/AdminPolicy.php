<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function viewAny(Admin $user): bool
    {
        $request = request();

        $id = (int) $request->resourceId;

        if ($user->id === $id) {
            return true;
        }

        return $user->hasAnyPermission(['view admin', 'create admin', 'update admin', 'delete admin']);
    }

    public function view(Admin $user, Admin $admin): bool
    {
        return ! $admin->hasAnyRole(Role::IGNORE_ROLES) && $user->hasPermissionTo('view admin');
    }

    public function create(Admin $user): bool
    {
        return $user->hasPermissionTo('create admin');
    }

    public function update(Admin $user, Admin $admin): bool
    {
        if ($user->id === $admin->id) {
            return true;
        }

        return ! $admin->hasAnyRole(Role::IGNORE_ROLES) && $user->hasPermissionTo('update admin');
    }

    public function delete(Admin $user, Admin $admin): bool
    {
        if ($user->id === $admin->id) {
            return false;
        }

        return ! $admin->hasAnyRole(Role::IGNORE_ROLES) && $user->hasPermissionTo('delete admin');
    }

    public function viewBackups(Admin $user): bool
    {
        return $user->hasPermissionTo('view backups');
    }

    public function viewSettings(Admin $user): bool
    {
        return $user->hasPermissionTo('view settings');
    }
}
