<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role as Model;

/**
 * @property string $name
 */
class Role extends Model
{
    public const IGNORE_ROLES = ['developer', 'owner'];

    protected $appends = ['prepared_permissions'];

    public function getPreparedPermissionsAttribute(): array
    {
        return $this->permissions->pluck('name')->toArray();
    }

    public function scopeIgnoreRoles(Builder $builder): Builder
    {
        return $builder->whereNotIn('name', self::IGNORE_ROLES);
    }

    public function scopeWithIgnoreRoles(Builder $builder): Builder
    {
        return $builder->whereIn('name', self::IGNORE_ROLES);
    }

    public function scopeOnlyOwner(Builder $builder): Builder
    {
        return $builder->whereIn('name', ['owner']);
    }

    public function scopeOnlyDeveloper(Builder $builder): Builder
    {
        return $builder->whereIn('name', ['developer']);
    }
}
