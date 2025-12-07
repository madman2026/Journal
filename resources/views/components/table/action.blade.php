@props(['editRoute', 'slug', 'viewRoute' => null, 'type' => null])

<div class="flex items-center gap-2">

    {{-- Edit Button --}}
    @if($editRoute)
        <x-core::form.button
            href="{{ route($editRoute, $slug) }}"
            variant="success"
        >
            <x-heroicon-o-pencil-square class="w-5 h-5" />
        </x-core::form.button>
    @endif

    <x-core::form.button
        variant="danger"
        wire:click="deleteContent('{{ $type }}', '{{ $slug }}')"
        wire:confirm="آیا از حذف مطمئن هستید؟"
    >
        <x-heroicon-o-trash class="w-5 h-5" />
    </x-core::form.button>

    {{-- View Button --}}
    @if($viewRoute)
        <x-core::form.button
            variant="sky"
            href="{{ route($viewRoute, $slug) }}"
        >
            <x-heroicon-o-eye class="w-5 h-5" />
        </x-core::form.button>
    @endif

</div>
