<?php

namespace App\Nova\Contracts;

use Arsenaltech\NovaTab\NovaTab;
use Arsenaltech\NovaTab\NovaTabs;
use Illuminate\Support\Collection;
use Laravel\Nova\Panel;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\FieldCollection;

trait Tabs
{
    public function updateFields(NovaRequest $request)
    {
        $updateFields = parent::updateFields($request);

        if (!$request->isMethod('get')) {
            return $updateFields;
        }

        $updateFields = $this->availableTabs($request, FieldCollection::make($updateFields));

        return $updateFields;
    }

    /**
     * Prepare the resource for JSON serialization.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function serializeForDetail(NovaRequest $request, Resource $resource)
    {
        $detailFields = parent::serializeForDetail($request, $resource);

        $detailFields['fields'] = $this->availableTabs($request, FieldCollection::make($detailFields['fields']));

        return $detailFields;
    }

    /**
     * Resolve the creation fields.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return \Illuminate\Support\Collection
     */
    public function creationFields(NovaRequest $request)
    {
        $creationFields = parent::creationFields($request);

        if (!$request->isMethod('get')) {
            return $creationFields;
        }

        return $this->availableTabs($request, FieldCollection::make($creationFields));
    }

    /**
     * Get the panels that are available for the given request.
     *
     * @param  \Laravel\Nova\Http\Requests\ResourceDetailRequest  $request
     * @return \Illuminate\Support\Collection
     */
    public function availableTabs(NovaRequest $request, FieldCollection $fields)
    {
        $method = $this->fieldsMethod($request);

        $tabs = collect(array_values($this->{$method}($request)))->whereInstanceOf(NovaTab::class)->values();

        if (count($tabs) > 0) {
            $this->assignFieldsToTabs($request, $fields);

            return FieldCollection::make([
                (NovaTabs::make('tabs'))->withMeta(['fields' => $fields->values()])
            ]);
        }

        return $fields;
    }


    protected function assignFieldsToTabs(NovaRequest $request, FieldCollection $fields)
    {
        $action = head(array_keys(array_filter([
            'create' => $request->isCreateOrAttachRequest(),
            'detail' => $request->isResourceDetailRequest(),
            'update' => $request->isUpdateOrUpdateAttachedRequest()
        ])));

        $method = Str::camel("default-name-for-{$action}");

        $resourceMethod = in_array($method, ['update', 'detail']) ? 'findResourceOrFail' : 'newResource';

        foreach ($fields as $field) {
            $name = $field->meta['tab'] ?? forward_static_call([Panel::class, $method], $request->{$resourceMethod}());

            $field->meta['tab'] = [
                'name' => $name,
                'html' => $field->meta['tabHTML'] ?? $name
            ];
        }

        return $fields;
    }
}
