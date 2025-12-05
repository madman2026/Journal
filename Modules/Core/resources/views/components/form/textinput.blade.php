@props([
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'accept' => null,
    'multiple' => false,
])

<div class="mb-6 w-full">
    <!-- Label -->
    @if($label)
        <label for="{{ $name }}"
               class="block text-sm font-medium
                      text-gray-700 dark:text-gray-200 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <!-- Input wrapper -->
    <div class="relative group">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            wire:model.lazy="{{ $name }}"
            id="{{ $name }}"
            value="{{ old($name, $value) }}"

            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($accept) accept="{{ $accept }}" @endif
            @if($multiple) multiple @endif

            {{ $attributes->merge([
                'class' =>
                    'block w-full rounded-xl px-4 py-3 border shadow-sm outline-none transition-all
                    bg-white text-gray-900
                    dark:bg-gray-900 dark:text-gray-100

                    border-gray-300
                    dark:border-gray-700

                    focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                    dark:focus:ring-indigo-400 dark:focus:border-indigo-400

                    hover:border-indigo-400
                    dark:hover:border-indigo-300

                    placeholder-gray-400 dark:placeholder-gray-500
                    '
                    . ($errors->has($name)
                        ? ' border-red-500 focus:ring-red-500 focus:border-red-500 dark:border-red-400 dark:focus:ring-red-400 dark:focus:border-red-400'
                        : '')
            ]) }}
        >
    </div>

    <!-- Error -->
    @error($name)
        <p class="text-red-500 dark:text-red-400 text-sm mt-1 flex items-center gap-1">
            <x-heroicon-o-exclamation-triangle class="w-4 h-4" />
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
