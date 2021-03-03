<?php

namespace App\Models;

use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    const IGNORE_ROLES = ['developer', 'owner'];

    protected $appends = ['prepared_permissions'];

    public function getPreparedPermissionsAttribute()
    {
        return $this->permissions->pluck('name')->toArray();
    }

    public function scopeIgnoreRoles($builder)
    {
        return $builder->whereNotIn('name', self::IGNORE_ROLES);
    }

    public function scopeWithIgnoreRoles($builder)
    {
        return $builder->whereIn('name', self::IGNORE_ROLES);
    }

    public function scopeOnlyOwner($builder)
    {
        return $builder->whereIn('name', ['owner']);
    }

    public function scopeOnlyDeveloper($builder)
    {
        return $builder->whereIn('name', ['developer']);
    }
}
