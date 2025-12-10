@props([
    'name',
    'label',
    'options' => [],
    'multiple' => false,
    'required' => false,
    'placeholder' => 'انتخاب کنید',
])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>

    <select
        name="{{ $name }}{{ $multiple ? '[]' : '' }}"
        wire:model.lazy="{{ $name }}"
        id="{{ $name }}"
        @if($multiple) multiple @endif
        @if($required) required @endif
        {{ $attributes->merge([
            'class' => 'block w-full rounded-lg border border-gray-300 dark:border-gray-600
                       bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100
                       p-3 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                       focus:border-blue-500 transition duration-150 ease-in-out
                       ' . ($errors->has($name) ? 'border-red-500' : '')
        ]) }}
    >
        @if(!$multiple)
            <option value="" disabled selected>{{ $placeholder }}</option>
        @endif

        @foreach($options as $value => $text)
            <option value="{{ $value }}">{{ $text }}</option>
        @endforeach
    </select>

    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
