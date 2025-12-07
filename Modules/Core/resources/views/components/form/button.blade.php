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

    $variants = [

        // PRIMARY (indigo)
        'primary' => $outline
            ? 'border border-indigo-600 text-indigo-600 bg-transparent hover:bg-indigo-50 focus:ring-indigo-500'
            : 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500 shadow-sm',

        // SECONDARY (gray)
        'secondary' => $outline
            ? 'border border-gray-400 text-gray-800 bg-transparent hover:bg-gray-100 focus:ring-gray-300'
            : 'bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-300',

        // DANGER (red)
        'danger' => $outline
            ? 'border border-red-600 text-red-600 bg-transparent hover:bg-red-50 focus:ring-red-500'
            : 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',

        // SUCCESS (green) ← جدید
        'success' => $outline
            ? 'border border-green-600 text-green-600 bg-transparent hover:bg-green-50 focus:ring-green-500'
            : 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',

        // WARNING (yellow) ← جدید
        'warning' => $outline
            ? 'border border-yellow-500 text-yellow-600 bg-transparent hover:bg-yellow-50 focus:ring-yellow-400'
            : 'bg-yellow-500 text-black hover:bg-yellow-600 focus:ring-yellow-400',

        // PURPLE ← جدید
        'purple' => $outline
            ? 'border border-purple-600 text-purple-600 bg-transparent hover:bg-purple-50 focus:ring-purple-500'
            : 'bg-purple-600 text-white hover:bg-purple-700 focus:ring-purple-500',

        // ORANGE ← جدید
        'orange' => $outline
            ? 'border border-orange-600 text-orange-600 bg-transparent hover:bg-orange-50 focus:ring-orange-500'
            : 'bg-orange-600 text-white hover:bg-orange-700 focus:ring-orange-500',

        'blue' => $outline
            ? 'border border-blue-600 text-blue-600 bg-transparent hover:bg-blue-50 focus:ring-blue-500'
            : 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',


        'sky' => $outline
            ? 'border border-blue-500 text-blue-500 bg-transparent hover:bg-blue-50 focus:ring-blue-500'
            : 'bg-blue-500 text-white hover:bg-blue-700 focus:ring-blue-500',

        // BLACK ← جدید
        'black' => $outline
            ? 'border border-black text-black bg-transparent hover:bg-gray-200 focus:ring-gray-700'
            : 'bg-black text-white hover:bg-gray-900 focus:ring-gray-700',

        // GHOST (شناور)
        'ghost' => 'bg-transparent text-gray-800 hover:bg-gray-100 focus:ring-gray-300',

        // LINK
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

        @if($icon)
            <span class="shrink-0">{!! $icon !!}</span>
        @endif

        <span class=" flex gap-1">{{ $slot }}</span>
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
