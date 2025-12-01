{{-- resources/views/components/ui/button.blade.php --}}
@props([
    'type' => 'button',            // button|submit|reset
    'variant' => 'primary',        // primary | secondary | danger | ghost | link
    'size' => 'md',                // xs | sm | md | lg
    'block' => false,              // full width when true
    'loading' => false,            // show spinner / disable
    'disabled' => false,           // disabled state
    'href' => null,                // if set, renders an <a> instead of <button>
    'outline' => false,            // outline style
    'icon' => null,                // optional icon (blade view or raw svg)
])

@php
    // base classes
    $base = 'inline-flex items-center justify-center gap-2 rounded-2xl font-medium transition-shadow focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-60 disabled:cursor-not-allowed';

    // block vs inline
    $display = $block ? 'w-full' : 'inline-block';

    // sizes
    $sizes = [
        'xs' => 'text-xs px-2 py-1.5',
        'sm' => 'text-sm px-3 py-2',
        'md' => 'text-base px-4 py-2.5',
        'lg' => 'text-lg px-5 py-3',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];

    // variants (ghost and link are special)
    $variants = [
        'primary' => $outline
            ? 'border border-indigo-600 text-indigo-600 bg-transparent hover:bg-indigo-50 focus:ring-indigo-500'
            : 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500 shadow-sm',
        'secondary' => $outline
            ? 'border border-gray-300 text-gray-700 bg-transparent hover:bg-gray-50 focus:ring-gray-300'
            : 'bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-300',
        'danger' => $outline
            ? 'border border-red-600 text-red-600 bg-transparent hover:bg-red-50 focus:ring-red-500'
            : 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        'ghost' => 'bg-transparent text-gray-800 hover:bg-gray-100 focus:ring-gray-300',
        'link' => 'bg-transparent underline text-indigo-600 hover:text-indigo-700 px-0 py-0',
    ];
    $variantClass = $variants[$variant] ?? $variants['primary'];

    $computedClass = trim("{$base} {$display} {$sizeClass} {$variantClass} {$attributes->get('class')}");
    $isDisabled = $disabled || $loading;
@endphp

@if ($href)
    <a
        href="{{ $href }}"
        {{ $attributes->merge(['class' => $computedClass, 'aria-disabled' => $isDisabled ? 'true' : 'false']) }}
        @if($isDisabled) tabindex="-1" aria-disabled="true" @endif
    >
        {{-- spinner --}}
        @if($loading)
            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
        @endif

        {{-- icon slot or prop --}}
        @if($icon)
            <span class="shrink-0">{!! $icon !!}</span>
        @endif

        <span>{{ $slot }}</span>
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge([
            'class' => $computedClass,
            'disabled' => $isDisabled,
            'aria-busy' => $loading ? 'true' : 'false',
        ]) }}
    >
        @if($loading)
            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
        @endif

        @if($icon && !$loading)
            <span class="shrink-0">{!! $icon !!}</span>
        @endif

        <span>{{ $slot }}</span>
    </button>
@endif
