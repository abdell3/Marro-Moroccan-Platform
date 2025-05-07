@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'fullWidth' => false
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors';
    
    $variantClasses = match($variant) {
        'primary' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
        'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-800 focus:ring-gray-500',
        'outline' => 'border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 focus:ring-red-500',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
        'link' => 'text-red-600 hover:text-red-700 underline bg-transparent',
        default => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
    };
    
    $sizeClasses = match($size) {
        'xs' => 'text-xs py-1 px-2',
        'sm' => 'text-sm py-1.5 px-3',
        'md' => 'text-sm py-2 px-4',
        'lg' => 'text-base py-2.5 px-5',
        'xl' => 'text-base py-3 px-6',
        default => 'text-sm py-2 px-4',
    };
    
    $widthClass = $fullWidth ? 'w-full' : '';
    
    $classes = "$baseClasses $variantClasses $sizeClasses $widthClass";
@endphp

<button 
    type="{{ $type }}" 
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</button>