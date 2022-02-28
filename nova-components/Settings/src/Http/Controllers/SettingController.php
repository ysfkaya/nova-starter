<?php

/** @noinspection PhpParamsInspection */

namespace Ysfkaya\Settings\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\ResourceIndexRequest;
use Laravel\Nova\Http\Requests\UpdateResourceRequest;
use Ysfkaya\Settings\Setting;

class SettingController extends Controller
{
    use ValidatesRequests;

    /**
     * Get all tabs with tab fields
     *
     *
     * @return \Illuminate\Support\Collection
     */
    public function tabs()
    {
        return Setting::allTabs()->values();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(Request $request)
    {
        $this->validate($request, Setting::rules(), [], Setting::customAttributes());

        $request = resolve(UpdateResourceRequest::class)->merge($request->all());

        $attributes = Setting::filledModels($request)->map->flatMap(function ($model) {
            return [$model->key => $model->value];
        })->values()->flatMap(function ($v) {
            return $v->all();
        })->filter(function ($v, $k) {
            return !empty($k);
        })->all();

        setting($attributes)->save();

        return response()->json([
            'success' => true,
            'reload' => false,
        ]);
    }

    /**
     * Delete the file given from request
     *
     * @param string $attribute
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFile($attribute)
    {
        $attribute = key($this->replaceBrackets([$attribute => $attribute]));

        $fileName = setting($attribute);

        Storage::disk(Setting::$disk)->delete($fileName);

        setting()->set($attribute, null);

        setting()->save();

        return response()->json([
            'success' => true,
        ]);
    }
}
