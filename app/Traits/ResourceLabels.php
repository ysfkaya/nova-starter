<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ResourceLabels
{

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __(Str::plural(self::classLabel()));
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __(Str::singular(self::classLabel()));
    }

    /**
     * Get the called class label
     *
     * @return string
     */
    protected static function classLabel()
    {
        return Str::title(Str::snake(class_basename(get_called_class()), ' '));
    }
}
