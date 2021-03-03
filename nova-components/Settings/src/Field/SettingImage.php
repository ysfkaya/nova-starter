<?php

namespace Ysfkaya\Settings\Field;

use Laravel\Nova\Fields\Image;

class SettingImage extends Image
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'setting-file-field';

    /**
     * The validation rules for creation and updates.
     *
     * @var array
     */
    public $rules = [
        'image',
    ];
}
