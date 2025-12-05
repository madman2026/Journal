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

        {{-- Upload Area --}}
        <label
            class="flex flex-col items-center justify-center w-full p-5 border-2 border-dashed rounded-xl cursor-pointer transition
                   bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 shadow-sm hover:shadow-md
                   hover:border-indigo-400 dark:hover:border-indigo-300"
            @mouseenter="hover = true"
            @mouseleave="hover = false"
        >
            <x-heroicon-o-arrow-up-tray
                class="w-10 h-10 text-gray-400 dark:text-gray-500 transition-all"
                x-bind:class="hover ? 'scale-110 text-indigo-500 dark:text-indigo-300' : ''"
            />

            <span class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                فایل خود را انتخاب کنید
            </span>

            <input
                type="file"
                wire:model="{{ $name }}"
                @if($accept) accept="{{ $accept }}" @endif
                @if($multiple) multiple @endif
                class="hidden"
            />
        </label>

        {{-- Progress Bar --}}
        <template x-if="uploading">
            <div class="w-full flex flex-col gap-1">
                <div class="w-full bg-gray-200 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                    <div
                        class="h-full bg-indigo-500 dark:bg-indigo-400 transition-all duration-200"
                        :style="`width: ${progress}%;`"
                    ></div>
                </div>
                <p class="text-xs text-gray-600 dark:text-gray-400" x-text="progress + '%'"></p>
            </div>
        </template>

        {{-- PREVIEW --}}
        @php
            $value = data_get($this, $name);
            $files = $value ? (is_array($value) ? $value : [$value]) : [];
        @endphp

        @if(count($files))
            <div class="flex flex-wrap gap-3 mt-3">

                @foreach($files as $file)
                    {{-- Temporary file --}}
                    @if($file instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                        @php
                            $mime = $file->getMimeType();
                        @endphp

                        @if(str_starts_with($mime, 'image/'))
                            <img src="{{ $file->temporaryUrl() }}" class="max-h-40 rounded-md shadow" />
                        @else
                            <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-lg text-sm text-gray-600 dark:text-gray-300">
                                فایل: {{ $file->getClientOriginalName() }}
                            </div>
                        @endif

                    {{-- Stored string path --}}
                    @elseif(is_string($file))
                        <img src="{{ $file }}" class="max-h-40 rounded-md shadow" />
                    @endif
                @endforeach

            </div>
        @endif

        {{-- Error --}}
        @error($name)
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

    </div>
</div>
