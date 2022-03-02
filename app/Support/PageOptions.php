<?php

namespace App\Support;

use App\Models\Page;
use ArrayAccess;

/**
 * @property object $seo
 */
class PageOptions implements ArrayAccess
{
    public Page $page;

    public array $options;

    public object $object;

    public function __construct(Page $page)
    {
        $this->page = $page;

        $this->options = $this->page->options;

        $this->object = json_decode(json_encode($this->options), false, 512, JSON_FORCE_OBJECT);
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    public function offsetExists($key): bool
    {
        return isset($this->options[$key]);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->options[$key] ?? '';
    }

    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value): void
    {
        if (is_null($key)) {
            $this->options[] = $value;
        } else {
            $this->options[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key): void
    {
        unset($this->options[$key]);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->object->{$key} ?? '';
    }
}
