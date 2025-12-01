@props([
    'name',
    'label',
    'options' => [],
    'selected' => null,
    'multiple' => false,
    'required' => false,
])

<div class="mb-6">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
    </label>

    <select
        name="{{ $name }}{{ $multiple ? '[]' : '' }}"
        id="{{ $name }}"
        @if($multiple) multiple @endif
        @if($required) required @endif
        {{ $attributes->merge([
            'class' =>
                'mt-1 block w-full border border-gray-300 dark:border-gray-600 rounded-md p-3 dark:bg-gray-800 dark:text-white ' .
                ($errors->has($name) ? 'border-red-500' : '')
        ]) }}
    >
        @foreach($options as $value => $text)
            <option value="{{ $value }}"
                @if($multiple)
                    {{ in_array($value, old($name, $selected ?? [])) ? 'selected' : '' }}
                @else
                    {{ old($name, $selected) == $value ? 'selected' : '' }}
                @endif
            >
                {{ $text }}
            </option>
        @endforeach
    </select>

    @error($name)
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
