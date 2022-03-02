<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission as Model;

/**
 * @property string $group
 * @property string $name
 */
class Permission extends Model
{
    public const ACTIONS = [
        'create',
        'delete',
        'update',
        'view',
        'restore',
        'force delete',
    ];

    protected $appends = [
        'translated_name',
    ];

    public function getTranslatedNameAttribute(): string
    {
        if (! isset($this->attributes['name'])) {
            return '';
        }

        $attribute = $this->attributes['name'];

        $name = Str::of($attribute)->after($action = $this->getAction($attribute))->title()->trim()->__toString();

        $action = Str::of($action)->title()->trim()->__toString();

        return __("$action :resource", ['resource' => __($name)]);
    }

    private function getAction(string $name): mixed
    {
        $actions = explode(' ', $name);

        $key = -1;

        foreach (self::ACTIONS as $action) {
            $key = array_search($action, $actions);

            if ($key !== false) {
                break;
            }
        }

        return $actions[$key] ?? head($actions);
    }
}
