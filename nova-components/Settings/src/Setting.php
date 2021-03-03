<?php

namespace Ysfkaya\Settings;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\File;

/**
 * Class Setting
 *
 * @package Ysfkaya\Settings
 */
class Setting
{
    const BRACKETS = '__';

    /**
     * @var array
     */
    public static $tabs = [];

    /**
     * @var array
     */
    public static $appendTabs = [];

    /**
     * @var Collection
     */
    public static $cachedTabs;

    /**
     * @var string
     */
    public static $disk = 'public';

    /**
     * @param string $name
     * @param string $key
     * @param array $fields
     *
     * @return static
     */
    public static function tab(string $name, string $key, array $fields)
    {
        $fields = self::mappedFields($fields);

        self::$tabs[$key] = [
            'name' => $name,
            'fields' => $fields
        ];

        return new static;
    }

    /**
     * @param string $name
     * @param string $key
     * @param array $fields
     *
     * @return static
     */
    public static function appendTab(string $name, string $key, array $fields)
    {
        $fields = self::mappedFields($fields);

        self::$appendTabs[$key] = [
            'name' => $name,
            'fields' => $fields
        ];

        return new static;
    }

    /**
     * @param string $brackets
     *
     * @return array
     */
    public static function rules($brackets = self::BRACKETS)
    {
        $rules = [];

        self::allTabs($brackets)->each(function ($tab) use (&$rules) {
            foreach ($tab['fields'] as $field) {
                $rules[$field->attribute] = $field->rules;
            }
        });

        return $rules;
    }

    /**
     * @param string $brackets
     *
     * @return array
     */
    public static function customAttributes($brackets = self::BRACKETS)
    {
        $attributes = [];

        self::allTabs($brackets)->each(function ($tab) use (&$attributes) {
            foreach ($tab['fields'] as $field) {
                $attributes[$field->attribute] = Str::ucfirst(Str::lower($field->name));
            }
        });

        return $attributes;
    }

    /**
     * @param string $brackets
     *
     * @return \Illuminate\Support\Collection
     */
    public static function allTabs($brackets = self::BRACKETS)
    {
        if (self::$cachedTabs[$brackets] ?? false) {
            return self::$cachedTabs[$brackets];
        }

        return self::$cachedTabs[$brackets] = collect(self::$tabs)
            ->merge(self::$appendTabs)
            ->map(function ($tab, $key) use ($brackets) {
                $tab['key'] = $key;

                $tab['fields'] = array_map(function (Field $field) use ($key, $brackets) {
                    $attribute = $field->attribute;

                    $field->attribute = $key . $brackets . $field->attribute;

                    $defaultCallback = Closure::bind(fn($class) => $class->defaultCallback, null, get_class($field))($field);

                    $default = $field->value ?? value($defaultCallback);

                    $value = setting($key . '.' . $attribute, $default);

                    $field->value = $value;

                    if ($field instanceof Boolean) {
                        $field->value = (bool)$value;
                    }

                    return $field;
                }, $tab['fields']);

                return $tab;
            });
    }

    /**
     * @param array $fields
     *
     * @return array
     */
    protected static function mappedFields(array $fields)
    {
        return collect($fields)->map(function ($field) {
            if ($field instanceof File) {
                $field = $field->disk(self::$disk);
            }

            return $field;
        })->toArray();
    }
}
