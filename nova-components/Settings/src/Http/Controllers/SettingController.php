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

        $requestAttributes = $this->replaceBrackets($request->except('_token', '_method'));

        $attributes = array_filter($requestAttributes, function ($value) {
            return !is_null($value);
        });

        foreach ($attributes as $key => $attribute) {
            if ($attribute instanceof UploadedFile) {
                $currentFile = setting($key);

                if ($currentFile && Storage::disk(Setting::$disk)->exists($currentFile)) {
                    Storage::disk(Setting::$disk)->delete($currentFile);
                }

                $attributes[$key] = $attribute->store('media/settings', Setting::$disk);
            }
        }

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

    /**
     * @param array $data
     *
     * @param string $from
     * @param string $to
     *
     * @return array
     */
    protected function replaceBrackets(array $data, $from = Setting::BRACKETS, $to = '.')
    {
        return collect($data)
            ->mapWithKeys(function ($attr, $key) use ($from, $to) {
                $replacedKey = Str::replaceFirst($from, $to, $key);

                return [$replacedKey => $attr];
            })->toArray();
    }
}
