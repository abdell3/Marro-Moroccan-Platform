@props(['type' => 'info', 'message'])

@php
    $classes = match($type) {
        'success' => 'bg-green-50 border-green-400 text-green-700',
        'error' => 'bg-red-50 border-red-400 text-red-700',
        'warning' => 'bg-yellow-50 border-yellow-400 text-yellow-700',
        default => 'bg-blue-50 border-blue-400 text-blue-700',
    };
@endphp

<div {{ $attributes->merge(['class' => "border-l-4 p-4 rounded-md $classes"]) }} role="alert">
    <p class="font-medium">{{ $message }}</p>
</div>