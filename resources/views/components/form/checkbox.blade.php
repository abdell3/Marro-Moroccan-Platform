@props(['name', 'label', 'value' => null, 'checked' => false])

<div class="flex items-center mb-4">
    <input 
        type="checkbox" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        value="{{ $value }}" 
        @if(old($name, $checked)) checked @endif
        {{ $attributes->merge(['class' => 'h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500']) }}
    >
    
    <label for="{{ $name }}" class="ml-2 block text-sm text-gray-700">
        {!! $label !!}
    </label>
    
    @error($name)
        <div class="absolute mt-6 ml-6 text-sm text-red-600">{{ $message }}</div>
    @enderror
</div>