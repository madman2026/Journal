<div class="container mx-auto p-4" wire:init="render">

    {{-- Search Form --}}
    <div class="flex flex-col lg:flex-row items-center mx-auto w-full max-w-lg
                space-y-2 lg:space-y-0 lg:space-x-2">

        <x-core::form.text-input name="search" label="جست و جو" placeholder="جست‌وجو..." type="text" />

        <x-core::form.select label="نوع" :options="$types" name="selectedType" :multiple="false" />
    </div>

    <h1 class="text-2xl font-semibold mb-4 text-center mt-5">نتایج جست‌وجو</h1>


    {{-- Results --}}
    <div>

        @if($results->count() === 0)
            <p class="text-center text-gray-600 dark:text-gray-400">هیچ محتوایی پیدا نشد.</p>
        @else

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach($results as $item)
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">

                        {{-- Image --}}
                        @if($item->image)
                            <img src="{{ asset($item->image) }}"
                                 alt="{{ $item->title }}"
                                 class="w-full h-48 object-cover rounded mb-4">
                        @else
                            <div class="w-full h-48 bg-gray-300 dark:bg-gray-700 rounded mb-4
                                        flex items-center justify-center">
                                <span class="text-gray-600 dark:text-gray-300 text-sm">بدون تصویر</span>
                            </div>
                        @endif

                        {{-- Title --}}
                        <h2 class="text-lg font-semibold mb-2">{{ $item->title }}</h2>

                        {{-- Category + Type --}}
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                            دسته‌بندی: {{ $item->categories->first()->name ?? 'بدون دسته' }}
                        </div>

                        {{-- Body --}}
                        <p class="text-gray-700 dark:text-gray-300">
                            {{ Str::limit($item->body ?? '...', 100) }}
                        </p>

                        {{-- Link --}}
                        <a href="{{ route("$type.show", $item->slug) }}"
                           class="text-blue-500 dark:text-blue-400 hover:underline mt-4 block">
                            بیشتر
                        </a>

                    </div>
                @endforeach

                {{-- Pagination --}}
                <div class="col-span-full flex justify-center mt-6">
                    {{ $results->links() }}
                </div>
            </div>

        @endif

    </div>
</div>
