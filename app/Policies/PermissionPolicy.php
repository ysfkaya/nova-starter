<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny($user): bool
    {
        return false;
    }

    public function view($user, $admin): bool
    {
        return false;
    }

    public function create($user): bool
    {
        return false;
    }

    public function update($user, $admin): bool
    {
        return false;
    }

    public function delete($user, $admin): bool
    {
        return false;
    }
}
