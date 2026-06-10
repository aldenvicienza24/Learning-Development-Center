<x-layouts::app.sidebar :title="$title ?? null">
<head>
    @include('partials.head')
</head>
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>
