@php
    $icon = <<<HTML
    <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
        <path fill="var(--sidebar-icon)" d="M3 1h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3h-4zM3 11h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4h-4z"
        />
    </svg>
HTML;
@endphp

@if (count(\Laravel\Nova\Nova::availableResources(request())))
    @foreach($navigation as $group => $resources)
        @foreach($resources as $resource)
            <router-link tag="h3" :to="{
                        name: 'index',
                        params: {
                            resourceName: '{{ $resource::uriKey() }}'
                        }
                    }" class="cursor-pointer flex items-center font-normal dim text-white mb-6 text-base no-underline mr-4">
                {!! method_exists($resource,'icon') ? $resource::icon() : $icon !!}
                <span class="sidebar-label">
                    {{ $resource::label() }}
                </span>
            </router-link>
        @endforeach
    @endforeach
@endif
