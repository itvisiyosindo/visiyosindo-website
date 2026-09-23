<x-layouts.dashboard 
    :breadcrumbs="isset($breadcrumbs) ? $breadcrumbs : [['label' => 'Dashboard']]"
>
    <x-slot:pageHeader>
        @if(isset($pageHeader))
            {{ $pageHeader }}
        @endif
    </x-slot:pageHeader>

    @yield('content')
</x-layouts.dashboard>
