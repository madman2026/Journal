@props([
    'title',
    'items',
    'type',
    'defaultLink',
    'containerClass',
    'emptyMessage' => 'موردی موجود نیست',
    'bgClass' => 'bg-blue-300 dark:bg-darkPrimary',
])

<section class="mx-4">
    <a href="{{ $defaultLink }}"
       class="text-4xl font-bold hover:text-blue-600 dark:text-white block mb-4 text-center">
       {{ $title }}
    </a>
    <div class="rounded-xl p-4 {{ $bgClass }} shadow-lg">
        @if($items->isNotEmpty())
            <x-slider
                :items="$items"
                :type="$type"
                :defaultLink="$defaultLink"
                :containerClass="$containerClass"
            />
        @else
            <p class="text-center text-gray-500 dark:text-gray-400">
                {{ $emptyMessage }}
            </p>
        @endif
    </div>
</section>
