@props([
    'type' => 'button',
    'color' => 'primary',
    'href' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150';
    
    $colorClasses = [
        'primary' => 'bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 text-white focus:ring-indigo-500',
        'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-800 focus:ring-gray-500',
        'success' => 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
    ][$color];
    
    $classes = $baseClasses . ' ' . $colorClasses;
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        <span class="flex items-center relative">
            {{ $slot }}
            
            <span class="absolute -inset-0.5 rounded-full animate-pulse-light opacity-0 group-hover:opacity-100"></span>
        </span>
    </button>
@endif

<style>
    @keyframes pulse-light {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.2);
        }
        50% {
            box-shadow: 0 0 0 6px rgba(255, 255, 255, 0);
        }
    }
    .animate-pulse-light {
        animation: pulse-light 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>