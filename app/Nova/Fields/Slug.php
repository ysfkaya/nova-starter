<?php

namespace App\Nova\Fields;

use Laravel\Nova\Fields\Slug as Field;

class Slug extends Field
{
    /**
     * Show customize button action.
     *
     * @param bool|callable $value
     *
     * @return $this
     */
    public function showCustomizeButton($value = true)
    {
        $this->showCustomizeButton = $value;

        return $this;
    }

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return ['showCustomizeButton' => value($this->showCustomizeButton)] + parent::jsonSerialize();
    }
}
