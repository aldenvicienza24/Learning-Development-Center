@props([
    'status',
])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-[#9CB0CF]']) }}>
        {{ $status }}
    </div>
@endif
