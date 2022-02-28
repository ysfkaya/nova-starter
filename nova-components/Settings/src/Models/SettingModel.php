<?php

namespace Ysfkaya\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Ysfkaya\Settings\Setting;

class SettingModel extends Model
{
    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        parent::setAttribute(
            $this->keyName(),
            Setting::replaceBrackets($key)
        );

        parent::setAttribute(
            $this->valueName(),
            $value
        );

        return $this;
    }

    public function keyName()
    {
        return config('setting.database.key', 'key');
    }

    public function valueName()
    {
        return config('setting.database.value', 'value');
    }

    /**
     * Get the current connection name for the model.
     *
     * @return string|null
     */
    public function getConnectionName()
    {
        return config('setting.database.connection');
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('setting.database.table', 'settings');
    }
}
