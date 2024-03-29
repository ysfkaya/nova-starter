<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
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
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50),

            Text::make('Kullanıcı Adı', 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Şifre', 'password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),
        ];
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
     * Get the icon.
     *
     * @return string
     */
    public static function icon()
    {
        return <<<'HTML'
<svg class="sidebar-icon" id="Capa_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m256 207c47.972 0 87-39.028 87-87s-39.028-87-87-87-87 39.028-87 87 39.028 87 87 87zm0-144c31.43 0 57 25.57 57 57s-25.57 57-57 57-57-25.57-57-57 25.57-57 57-57z"/><path d="m432 207c30.327 0 55-24.673 55-55s-24.673-55-55-55-55 24.673-55 55 24.673 55 55 55zm0-80c13.785 0 25 11.215 25 25s-11.215 25-25 25-25-11.215-25-25 11.215-25 25-25z"/><path d="m444.1 241h-23.2c-27.339 0-50.939 16.152-61.693 39.352-22.141-24.17-53.944-39.352-89.228-39.352h-27.957c-35.284 0-67.087 15.182-89.228 39.352-10.755-23.2-34.355-39.352-61.694-39.352h-23.2c-37.44 0-67.9 30.276-67.9 67.49v109.21c0 16.156 13.194 29.3 29.412 29.3h91.727c1.538 17.9 16.59 32 34.883 32h199.957c18.292 0 33.344-14.1 34.883-32h90.679c16.796 0 30.46-13.61 30.46-30.34v-108.17c-.001-37.214-30.461-67.49-67.901-67.49zm-414.1 67.49c0-20.672 17.002-37.49 37.9-37.49h23.2c20.898 0 37.9 16.818 37.9 37.49v10.271c-10.087 26.264-8 42.004-8 98.239h-91zm331 135.489c0 2.769-2.252 5.021-5.021 5.021h-199.958c-2.769 0-5.021-2.253-5.021-5.021v-81.957c0-50.19 40.832-91.022 91.021-91.022h27.957c50.19 0 91.022 40.832 91.022 91.021zm121-27.319c0 .517 5.592.34-91 .34 0-56.651 2.071-72.018-8-98.239v-10.271c0-20.672 17.002-37.49 37.9-37.49h23.2c20.898 0 37.9 16.818 37.9 37.49z"/><path d="m80 207c30.327 0 55-24.673 55-55s-24.673-55-55-55-55 24.673-55 55 24.673 55 55 55zm0-80c13.785 0 25 11.215 25 25s-11.215 25-25 25-25-11.215-25-25 11.215-25 25-25z"/></g></svg>
HTML;
    }
}
