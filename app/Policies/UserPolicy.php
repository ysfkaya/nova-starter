<?php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(Admin $user): bool
    {
        return $user->hasAnyPermission(['view user', 'create user', 'update user', 'delete user']);
    }

    public function view(Admin $user): bool
    {
        return $user->hasPermissionTo('view user');
    }

    public function create(Admin $user): bool
    {
        return $user->hasPermissionTo('create user');
    }

    public function update(Admin $user): bool
    {
        return $user->hasPermissionTo('update user');
    }

    public function delete(Admin $user): bool
    {
        return $user->hasPermissionTo('delete user');
    }
}
