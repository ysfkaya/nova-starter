<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as Model;
use Illuminate\Support\Str;

class Permission extends Model
{
    const ACTIONS = [
        'create',
        'delete',
        'update',
        'view',
        'restore',
        'force delete'
    ];

    protected $appends = [
        'translated_name'
    ];

    public function getTranslatedNameAttribute()
    {
        if (!isset($this->attributes['name'])) return '';

        $attribute = $this->attributes['name'];

        $name = Str::of($attribute)->after($action = $this->getAction($attribute))->title()->trim()->__toString();

        $action = Str::of($action)->title()->trim()->__toString();

        return __("$action :resource", ['resource' => __($name)]);
    }

    private function getAction($name)
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
