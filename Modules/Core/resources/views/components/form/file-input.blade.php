@props([
    'name',
    'label' => null,
    'accept' => '',
    'multiple' => false,
])

<div class="mb-6 w-full">
    @if($label)
        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }}
        </label>
    @endif

    <div
        x-data="{ uploading: false, progress: 0, hover: false }"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false; progress = 0"
        x-on:livewire-upload-cancel="uploading = false; progress = 0"
        x-on:livewire-upload-error="uploading = false; progress = 0"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
        class="space-y-3"
    >

        <!-- Input -->
        <label
            class="flex flex-col items-center justify-center w-full p-5 border-2 border-dashed rounded-xl transition
                   bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600
                   hover:border-indigo-400 dark:hover:border-indigo-300 cursor-pointer shadow-sm hover:shadow-md"
            @mouseenter="hover = true"
            @mouseleave="hover = false"
        >
            <x-heroicon-o-arrow-up-tray
                class="w-10 h-10 text-gray-400 dark:text-gray-500 transition-all"
                x-bind:class="hover ? 'scale-110 text-indigo-500 dark:text-indigo-300' : ''"
            />

            <span class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                فایل‌هاتو انتخاب کن
            </span>

            <input
                type="file"
                wire:model="{{ $name }}"
                @if($accept) accept="{{ $accept }}" @endif
                @if($multiple) multiple @endif
                class="hidden"
            />
        </label>

        <!-- Progress -->
        <template x-if="uploading">
            <div class="w-full flex flex-col gap-1 transition-opacity duration-300 opacity-100">
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                    <div
                        class="h-full bg-indigo-500 dark:bg-indigo-400 transition-all duration-200"
                        :style="`width: ${progress}%;`"
                    ></div>
                </div>
                <p class="text-xs text-gray-600 dark:text-gray-400 text-left" x-text="progress + '%'"></p>
            </div>
        </template>

        <!-- Preview -->
        @php
            $parts = explode('.', $name);
            $prop = $parts[0] ?? null;
            $index = $parts[1] ?? null;

            $fileValue = null;

            if ($prop && $index) {
                $fileValue = $this->{$prop}[$index] ?? null;
            } elseif ($prop && isset($this->{$prop})) {
                $fileValue = $this->{$prop};
            }
        @endphp

        @if($fileValue)
            <div class="flex flex-wrap gap-3 mt-3">
                @php
                    $files = is_array($fileValue) ? $fileValue : [$fileValue];
                @endphp

                @foreach($files as $file)
                    @if($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                        <img src="{{ $file->temporaryUrl() }}" class="max-h-40 rounded-md" />
                    @elseif(is_string($file))
                        <img src="{{ $file }}" class="max-h-40 rounded-md" />
                    @endif
                @endforeach
            </div>
        @endif

        <!-- Error -->
        @error($name)
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
