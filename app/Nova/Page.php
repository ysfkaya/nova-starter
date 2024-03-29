<?php

namespace App\Nova;

use App\Nova\Contracts\Tabs;
use App\Nova\Support\PageFields;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Waynestate\Nova\CKEditor;

/**
 * @mixin \App\Models\Page
 */
class Page extends Resource
{
    use Tabs;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Page::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make(__('Title'), 'title'),

            Text::make(__('Url'), function () {
                return sprintf('<a href="%s" target="_blank">%s</a>', $this->url, $this->slug);
            })->asHtml(),

            CKEditor::make(__('Body'), 'body')->onlyOnDetail(),

            Select::make(__('Template'), 'template')->options(['home' => 'Anasayfa', 'page' => 'Sayfa'])->displayUsingLabels(),
        ];
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fieldsForUpdate(Request $request)
    {
        return PageFields::fieldsFor('update', $request, $this->resource);
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fieldsForCreate(Request $request)
    {
        return PageFields::fieldsFor('create', $request);
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    /**
     * Get the resource icon.
     *
     * @return string
     */
    public static function icon()
    {
        return <<<'HTML'
    <svg class="sidebar-icon" height="512pt" viewBox="0 -43 512.0005 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m405.378906 361.273438c-3.5-2.21875-8.132812-1.183594-10.351562 2.316406-18.730469 29.519531-50.753906 47.144531-85.664063 47.144531h-192.996093c-55.894532 0-101.367188-45.476563-101.367188-101.371094v-179.742187c0-4.140625-3.359375-7.5-7.5-7.5s-7.5 3.359375-7.5 7.5v179.742187c0 64.167969 52.203125 116.371094 116.367188 116.371094h192.996093c40.074219 0 76.835938-20.230469 98.328125-54.109375 2.21875-3.496094 1.183594-8.132812-2.3125-10.351562zm-65.9375-199.304688-57.183594 57.1875c-2.929687 2.929688-2.929687 7.679688 0 10.605469 1.460938 1.464843 3.382813 2.199219 5.300782 2.199219 1.917968 0 3.839844-.734376 5.304687-2.199219l57.183594-57.183594c2.929687-2.929687 2.929687-7.679687 0-10.609375-2.925781-2.925781-7.675781-2.925781-10.605469 0zm161.707032-124.957031-26.140626-26.140625c-14.46875-14.472656-38.015624-14.472656-52.484374 0l-27.136719 27.136718c-22.046875-24.25-52.945313-38.007812-86.023438-38.007812h-192.996093c-26.769532 0-52.90625 9.316406-73.597657 26.230469-20.398437 16.671875-34.667969 39.964843-40.171875 65.582031-.871094 4.050781 1.707032 8.039062 5.757813 8.910156.53125.109375 1.0625.167969 1.582031.167969 3.460938 0 6.570312-2.40625 7.324219-5.925781 4.796875-22.304688 17.222656-42.589844 35-57.121094 18.019531-14.730469 40.785156-22.84375 64.105469-22.84375h192.996093c29.046875 0 56.167969 12.179688 75.402344 33.628906l-79.757813 79.757813h-209.144531c-4.144531 0-7.503906 3.355469-7.503906 7.5 0 4.140625 3.359375 7.5 7.503906 7.5h194.144531l-35.960937 35.957031h-158.183594c-4.144531 0-7.503906 3.359375-7.503906 7.503906 0 4.140625 3.359375 7.5 7.503906 7.5h143.183594l-46.523437 46.523438c-13.480469 13.480468-24.511719 29.027344-32.78125 46.207031l-21.347657 44.347656c-5.90625 12.277344-3.5 26.433594 6.132813 36.066407 6.125 6.125 14.082031 9.328124 22.222656 9.328124 4.65625 0 9.375-1.050781 13.839844-3.199218l21.515625-10.355469c.003906-.003906.011719-.003906.015625-.007813l22.820312-10.980468c17.175782-8.269532 32.722656-19.300782 46.207032-32.78125l139.585937-139.585938v129.453125c0 8.214844-.984375 16.382813-2.925781 24.28125-.988282 4.023438 1.472656 8.082031 5.496094 9.070313.601562.148437 1.203124.21875 1.792968.21875 3.375 0 6.4375-2.289063 7.277344-5.710938 2.230469-9.066406 3.359375-18.441406 3.359375-27.859375v-144.453125l20.847656-20.847656c.003907-.003906.003907-.003906.003907-.007812.003906 0 .003906 0 .003906-.003907l54.558594-54.554687c14.46875-14.472656 14.46875-38.015625 0-52.484375zm-327.0625 323.09375c-7.828126 3.769531-14.921876.808593-18.953126-3.21875-4.027343-4.03125-6.988281-11.125-3.21875-18.953125l6.328126-13.152344c5.28125 4.222656 10.40625 8.800781 15.300781 13.695312 4.894531 4.894532 9.472656 10.019532 13.695312 15.300782zm44.347656-21.34375-17.355469 8.351562c-5.144531-6.671875-10.8125-13.128906-16.929687-19.242187-6.117188-6.117188-12.574219-11.789063-19.242188-16.929688l8.351562-17.355468c5.765626-11.972657 13-23.070313 21.582032-33.125l56.71875 56.71875c-10.054688 8.578124-21.152344 15.816406-33.125 21.582031zm44.078125-31.84375-57.410157-57.410157 168.164063-168.167968 57.410156 57.410156zm178.773437-178.773438-57.410156-57.410156 18.515625-18.515625 57.414063 57.410156zm49.257813-49.257812-20.132813 20.132812-57.410156-57.410156 20.128906-20.132813c4.3125-4.3125 9.972656-6.464843 15.636719-6.464843 5.660156 0 11.324219 2.152343 15.632813 6.464843l26.140624 26.140626c8.621094 8.621093 8.621094 22.648437.003907 31.269531zm-394.679688 13.539062h234.007813c4.140625 0 7.5-3.355469 7.5-7.5s-3.359375-7.5-7.5-7.5h-234.007813c-4.144531 0-7.503906 3.355469-7.503906 7.5s3.359375 7.5 7.503906 7.5zm0 0"/></svg>
HTML;
    }
}
