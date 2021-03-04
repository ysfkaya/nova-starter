<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full font-sans antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=1280">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ \Laravel\Nova\Nova::name() }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('app.css', 'vendor/nova') }}">

    <!-- Tool Styles -->
    @foreach(\Laravel\Nova\Nova::availableStyles(request()) as $name => $path)
        @if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://']))
            <link rel="stylesheet" href="{!! $path !!}">
        @else
            <link rel="stylesheet" href="/nova-api/styles/{{ $name }}">
        @endif
    @endforeach

    <!-- Custom Meta Data -->
    @include('nova::partials.meta')

    <!-- Theme Styles -->
    @foreach(\Laravel\Nova\Nova::themeStyles() as $publicPath)
        <link rel="stylesheet" href="{{ $publicPath }}">
    @endforeach
</head>
<body class="min-w-site bg-40 text-90 font-medium min-h-full">
    <div id="nova">
        <div v-cloak class="flex min-h-screen">
            <!-- Sidebar -->
            <div class="min-h-screen flex-none pt-header min-h-screen w-sidebar bg-grad-sidebar px-6">
                <a href="{{ \Laravel\Nova\Nova::path() }}">
                    <div class="absolute pin-t pin-l pin-r bg-logo flex items-center w-sidebar h-header px-6 text-white">
                       @include('nova::partials.logo')
                    </div>
                </a>

                @foreach (\Laravel\Nova\Nova::availableTools(request()) as $tool)
                    {!! $tool->renderNavigation() !!}
                @endforeach
            </div>

            <!-- Content -->
            <div class="content flex flex-col">
                <div class="flex items-center relative shadow h-header bg-white z-20 px-view">
                    <a v-if="@json(\Laravel\Nova\Nova::name() !== null)" href="{{ \Illuminate\Support\Facades\Config::get('nova.url') }}" class="no-underline dim font-bold text-90 mr-6">
                        {{ \Laravel\Nova\Nova::name() }}
                    </a>

                    @if (count(\Laravel\Nova\Nova::globallySearchableResources(request())) > 0)
                        <global-search dusk="global-search-component"></global-search>
                    @endif

                     <div class="ml-auto notifications">
                        @include('nova-notifications::dropdown')
                    </div>

                    <tooltip class="ml-4 mr-4">
                        <tooltip-content slot="content">
                            Siteyi Gör
                        </tooltip-content>
                        <a href="{{ url('/') }}" target="_blank"
                            class="no-underline dim font-bold text-90 float-right flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 480.096 480"
                                aria-labelledby="globe" role="presentation" class="fill-current mr-2">
                                <g>
                                    <path
                                        d="m240.097656.046875h-.097656c-132.546875 0-240 107.453125-240 240 0 132.550781 107.453125 240 240 240h.097656c132.546875 0 240-107.449219 240-240 0-132.546875-107.453125-240-240-240zm205.964844 152h-106.167969c-6.191406-22.214844-14.820312-43.679687-25.734375-64h90.28125c17.421875 18.804687 31.5 40.449219 41.621094 64zm-206.039062-133.390625c17.492187 15.785156 32.914062 33.726562 45.886718 53.390625h-91.71875c12.957032-19.664063 28.355469-37.605469 45.832032-53.390625zm-65 53.390625h-82.855469c35.230469-31.15625 79.410156-50.382813 126.222656-54.925781-16.558594 16.542968-31.113281 34.980468-43.367187 54.925781zm86.671874-54.941406c46.851563 4.527343 91.070313 23.757812 126.328126 54.941406h-82.933594c-12.261719-19.953125-26.824219-38.394531-43.394532-54.941406zm34.128907 70.941406c11.683593 20.175781 20.949219 41.65625 27.609375 64h-166.679688c6.625-22.339844 15.871094-43.824219 27.535156-64zm-220.070313 0h90.207032c-10.894532 20.320313-19.503907 41.785156-25.671876 64h-106.160156c10.121094-23.550781 24.199219-45.195313 41.625-64zm-47.722656 80h424.128906c15.914063 46.683594 15.914063 97.320313 0 144h-424.128906c-15.914062-46.679687-15.914062-97.316406 0-144zm212 293.394531c-17.476562-15.785156-32.882812-33.726562-45.839844-53.394531h91.71875c-12.972656 19.667969-28.394531 37.609375-45.886718 53.394531zm65.058594-53.394531h82.933594c-35.277344 31.199219-79.523438 50.429687-126.398438 54.945313 16.59375-16.546876 31.183594-34.988282 43.464844-54.945313zm-86.699219 54.929687c-46.8125-4.546874-90.992187-23.769531-126.222656-54.929687h82.855469c12.253906 19.949219 26.808593 38.382813 43.367187 54.929687zm-34.101563-70.929687c-11.664062-20.175781-20.910156-41.65625-27.535156-64h166.679688c-6.660156 22.34375-15.925782 43.824219-27.609375 64zm-150.160156-64h106.160156c6.167969 22.214844 14.777344 43.679687 25.671876 64h-90.207032c-17.425781-18.800781-31.503906-40.449219-41.625-64zm370.3125 64h-90.28125c10.914063-20.316406 19.542969-41.78125 25.734375-64h106.167969c-10.121094 23.550781-24.199219 45.199219-41.621094 64zm0 0" />
                                    <path
                                        d="m64.375 282.152344c.941406 3.445312 4.046875 5.851562 7.617188 5.894531h.105468c3.53125 0 6.648438-2.316406 7.664063-5.703125l16.335937-54.457031 16.335938 54.457031c1.011718 3.386719 4.128906 5.703125 7.664062 5.703125h.101563c3.570312-.042969 6.679687-2.449219 7.617187-5.894531l24-88-15.441406-4.207032-16.648438 61.039063-16-53.230469c-1.011718-3.386718-4.128906-5.707031-7.664062-5.707031-3.53125 0-6.648438 2.320313-7.664062 5.707031l-16 53.230469-16.644532-61.039063-15.441406 4.207032zm0 0" />
                                    <path
                                        d="m215.992188 288.046875h.105468c3.53125 0 6.648438-2.316406 7.664063-5.703125l16.335937-54.457031 16.335938 54.457031c1.011718 3.386719 4.128906 5.703125 7.664062 5.703125h.101563c3.570312-.042969 6.679687-2.449219 7.617187-5.894531l24-88-15.441406-4.207032-16.648438 61.039063-16-53.230469c-1.011718-3.386718-4.128906-5.707031-7.664062-5.707031-3.53125 0-6.648438 2.320313-7.664062 5.707031l-16 53.230469-16.644532-61.039063-15.441406 4.207032 24 88c.945312 3.46875 4.085938 5.878906 7.679688 5.894531zm0 0" />
                                    <path
                                        d="m359.992188 288.046875h.105468c3.53125 0 6.648438-2.316406 7.664063-5.703125l16.335937-54.457031 16.335938 54.457031c1.011718 3.386719 4.128906 5.703125 7.664062 5.703125h.101563c3.570312-.042969 6.679687-2.449219 7.617187-5.894531l24-88-15.441406-4.207032-16.648438 61.039063-16-53.230469c-1.011718-3.386718-4.128906-5.707031-7.664062-5.707031-3.53125 0-6.648438 2.320313-7.664062 5.707031l-16 53.230469-16.644532-61.039063-15.441406 4.207032 24 88c.945312 3.46875 4.085938 5.878906 7.679688 5.894531zm0 0" />
                                </g>
                            </svg>
                        </a>
                    </tooltip>

                    <dropdown class="h-9 flex items-center dropdown-right">
                        @include('nova::partials.user')
                    </dropdown>
                </div>

                 <div data-testid="content" class="px-view py-view mx-auto w-full flex-grow">
                    @yield('content')
                </div>

                <footer class="sticky my-6">
                    @include('nova::partials.footer')
                </footer>
            </div>
        </div>
    </div>

    <script>
        window.config = @json(\Laravel\Nova\Nova::jsonVariables(request()));
    </script>

    <!-- Scripts -->
    <script src="{{ mix('manifest.js', 'vendor/nova') }}"></script>
    <script src="{{ mix('vendor.js', 'vendor/nova') }}"></script>
    <script src="{{ mix('app.js', 'vendor/nova') }}"></script>

    <!-- Build Nova Instance -->
    <script>
        window.Nova = new CreateNova(config)
    </script>

    <!-- Tool Scripts -->
    @foreach (\Laravel\Nova\Nova::availableScripts(request()) as $name => $path)
        @if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://']))
            <script src="{!! $path !!}"></script>
        @else
            <script src="/nova-api/scripts/{{ $name }}"></script>
        @endif
    @endforeach

    <!-- Start Nova -->
    <script>
        Nova.liftOff()
    </script>
</body>
</html>
