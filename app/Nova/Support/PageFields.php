<?php

namespace App\Nova\Support;

use App\Models\Page;
use App\Nova\Fields\Slug;
use Arsenaltech\NovaTab\NovaTab;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Waynestate\Nova\CKEditor;

class PageFields
{
    public static Request $request;
    public static Page $resource;

    /**
     * @return array
     */
    public static function fieldsFor($type, $request, $resource = null)
    {
        return match ($type) {
            'update' => self::fields($request, $resource),
            'create' => self::fields($request),
            default => []
        };
    }

    protected static function fields(Request $request, ?Page $resource = null): array
    {
        $untouchable = $resource && in_array($resource->slug, Page::DEFAULTS);

        return [
            new NovaTab(__('General'), [
                Text::make(__('Title'), 'title')->rules('required', 'string', 'max:255'),

                Slug::make(__('Slug'), 'slug')
                    ->rules('required', 'string', 'max:255')
                    ->from('title.en')
                    ->showCustomizeButton(!$untouchable),

                CKEditor::make(__('Body'), 'body')->rules('nullable'),

                Select::make(__('Template'), 'template')
                    ->rules('required')
                    ->options(['home' => 'Anasayfa', 'page' => 'Sayfa'])
                    ->displayUsingLabels()
                    ->default('page')
                    ->readonly($untouchable),
            ]),

            new NovaTab('SEO', [
                Text::make(__('Title'), 'options->seo->title')->rules('nullable', 'string', 'max:255'),
                Text::make(__('Description'), 'options->seo->description')->rules('nullable', 'string', 'max:160'),
            ])

        ];
    }
}
