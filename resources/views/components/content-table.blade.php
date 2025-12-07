@props([
    'items',
    'title',
    'editRoute' => null,
    'viewRoute' => null,
    'type' => null,
    'showImage' => false,
    'showBody' => false,
    'showFiles' => false
])

@php
    $colspan = 3;
    if($showImage) $colspan++;
    if($showBody) $colspan++;
    if($showFiles) $colspan++;
@endphp

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

    <x-table.header
        :title="$title"
        :count="$items->count() ? $items->total() : null"
    />

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    @if($showImage)
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            تصویر
                        </th>
                    @endif
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">عنوان</th>
                    @if($showBody)
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">متن</th>
                    @endif
                    @if($showFiles)
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">فایل‌ها</th>
                    @endif
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">تاریخ ایجاد</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">عملیات</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($items as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        @if($showImage)
                            <x-table.image-column :image="$item->image" :alt="$item->title" />
                        @endif
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ Str::limit($item->title, 50) }}
                            </div>
                        </td>
                        @if($showBody)
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                {{ Str::limit($this->extractContent($item), 80) }}
                            </td>
                        @endif
                        @if($showFiles)
                            <td class="px-4 py-3">
                                <x-table.file-download :filePath="$item->attachment" />
                                @if (!is_null($item->word))
                                    <x-table.file-download :filePath="$item->word" />
                                @endif
                            </td>


                        @endif
                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            {{ $item->created_at?->format('Y/m/d') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                            <x-table.action
                                :editRoute="$editRoute"
                                :viewRoute="$viewRoute"
                                :slug="$item->slug"
                                :type="$type" {{-- برای delete --}}
                            />
                        </td>
                    </tr>
                @empty
                    <x-table.empty-state :colspan="$colspan" />
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($items->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
            {{ $items->links() }}
        </div>
    @endif

</div>
