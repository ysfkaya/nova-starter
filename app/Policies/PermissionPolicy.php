<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return false;
    }

    public function view(): bool
    {
        return false;
    }

    public function create(): bool
    {
        return false;
    }

    public function update(): bool
    {
        return false;
    }

    public function delete(): bool
    {
        return false;
    }
}
