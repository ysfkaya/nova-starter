<?php

namespace Ysfkaya\Settings;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class SettingTool extends Tool
{

    protected $tabs = [];

    public function __construct(array $fields = [], $disk = 'public', $component = null)
    {
        parent::__construct($component);
    }

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->tabs as $tab) {
            Setting::tab($tab['label'], $tab['key'], $tab['fields']);
        }

        Nova::script('nova-settings', __DIR__ . '/../dist/js/tool.js');
        Nova::style('nova-settings', __DIR__ . '/../dist/css/tool.css');
    }

    public function tab($label, $key, array $fields)
    {
        $this->tabs[] = compact('label', 'key', 'fields');

        return $this;
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('nova-settings::navigation');
    }
}
