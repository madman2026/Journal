@props(['filePath'])

@if($filePath)
    <x-core::form.button wire:click="download('{{ $filePath }}')" >
        <x-heroicon-o-arrow-down-tray class="w-4 h-4 ml-1" />
    </x-core::form.button>
@else
    <span class="text-sm text-gray-500 dark:text-gray-400">بدون فایل</span>
@endif
