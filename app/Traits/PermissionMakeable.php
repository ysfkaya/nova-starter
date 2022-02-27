<?php

namespace App\Traits;

use App\Models\Permission;
use Illuminate\Support\Arr;

trait PermissionMakeable
{
    public $guardName = 'admin';

    protected $defaultPermissions = ['create', 'update', 'delete', 'force delete', 'view', 'restore'];

    protected $equivalentPermissions = [
        'c' => 'create',
        'r' => 'view',
        'u' => 'update',
        'd' => 'delete',
        'fd' => 'force delete',
        're' => 'restore',
    ];

    protected function makePermission($name, $exceptAbilities = [], $extraAbilities = [])
    {
        $permissions = [];

        $exceptAbilities = array_merge($exceptAbilities, ['force delete', 'restore']);

        $abilities = Arr::except(array_combine($this->defaultPermissions, $this->defaultPermissions), array_values($exceptAbilities));

        $abilities = array_merge($abilities, $extraAbilities);

        foreach ($abilities as $ability) {
            $ability = $this->equivalentPermissions[$ability] ?? $ability;

            $attributes = $this->withGuardAttribute(['name' => $ability.' '.$name]);

            $attributes = array_merge(['group' => $name], $attributes);

            $permissions[] = Permission::firstOrCreate($attributes);
        }

        return $permissions;
    }

    protected function makeOnlyPermission($name, $only = [])
    {
        return $this->makePermission($name, $this->defaultPermissions, $only);
    }

    protected function withGuardAttribute(array $attributes)
    {
        return array_merge($attributes, ['guard_name' => $this->guardName]);
    }
}
