<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function viewAny($user): bool
    {
        $request = request();

        $id = (int)$request->resourceId;

        if($user->id === $id){
            return true;
        }

        return $user->hasAnyPermission(['view admin', 'create admin', 'update admin', 'delete admin']);
    }

    public function view($user, $admin): bool
    {
        return !$admin->hasAnyRole(Role::IGNORE_ROLES) && $user->hasPermissionTo('view admin');
    }

    public function create($user): bool
    {
        return $user->hasPermissionTo('create admin');
    }

    public function update($user, $admin): bool
    {
        if ($user->id === $admin->id) {
            return true;
        }

        return !$admin->hasAnyRole(Role::IGNORE_ROLES) && $user->hasPermissionTo('update admin');
    }

    public function delete($user, $admin): bool
    {
        if ($user->id === $admin->id) {
            return false;
        }

        return !$admin->hasAnyRole(Role::IGNORE_ROLES) && $user->hasPermissionTo('delete admin');
    }
}
