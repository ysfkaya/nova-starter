<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Page;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function viewAny(Admin $user): bool
    {
        return $user->hasAnyPermission(['view page', 'create page', 'update page', 'delete page']);
    }

    public function view(Admin $user): bool
    {
        return $user->hasPermissionTo('view page');
    }

    public function create(Admin $user): bool
    {
        return $user->hasPermissionTo('create page');
    }

    public function update(Admin $user): bool
    {
        return $user->hasPermissionTo('update page');
    }

    public function delete(Admin $user, Page $page): bool
    {
        if (in_array($page->slug, Page::DEFAULTS)) {
            return false;
        }

        return $user->isSuper() || $user->hasPermissionTo('delete page');
    }
}
