<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny($user): bool
    {
        return $user->hasAnyPermission(['view user', 'create user', 'update user', 'delete user']);
    }

    public function view($user): bool
    {
        return $user->hasPermissionTo('view user');
    }

    public function create($user): bool
    {
        return $user->hasPermissionTo('create user');
    }

    public function update($user): bool
    {
        return $user->hasPermissionTo('update user');
    }

    public function delete($user): bool
    {
        return $user->hasPermissionTo('delete user');
    }
}
