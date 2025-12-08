
<main class="p-6 dark:bg-gray-900 dark:text-gray-100 min-h-screen">

    <!-- Header -->
    <div class="flex justify-between items-center w-full h-12 mb-6">
        <h1 class="text-2xl font-bold">لیست نظرات</h1>

        <x-core::form.button varient="success" wire:click="acceptAll()">
            تایید همه
        </x-core::form.button>
        <x-core::form.button varient="danger" wire:click="deleteAll()">
            تایید همه
        </x-core::form.button>
    </div>
    <!-- Table Container -->
    <div class="overflow-x-auto border border-gray-300 dark:border-gray-700 rounded-xl shadow-md">
        <table class="w-full border-collapse text-sm">
            <thead class="bg-gray-100 dark:bg-gray-800">
                <tr>
                    <th class="border border-gray-300 dark:border-gray-700 p-3">نویسنده</th>
                    <th class="border border-gray-300 dark:border-gray-700 p-3">محتوا</th>
                    <th class="border border-gray-300 dark:border-gray-700 p-3">متن</th>
                    <th class="border border-gray-300 dark:border-gray-700 p-3">تاریخ</th>
                    <th class="border border-gray-300 dark:border-gray-700 p-3">تایید</th>
                    <th class="border border-gray-300 dark:border-gray-700 p-3">حذف</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($comments as $comment)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <!-- نویسنده -->
                        <td class="border border-gray-300 dark:border-gray-700 p-3">
                            {{ $comment->user->username }}
                        </td>

                        <!-- محتوا -->
                        @php
                            $route = match($comment->commentable_type) {
                                'Modules\Magazine\Models\Article' => 'article.show',
                                'Modules\Activity\Models\Activity' => 'activity.show',
                                'Modules\Tip\Models\Tip' => 'tip.show',
                                'Modules\Magazine\Models\Magazine' => 'magazine.show',
                                default => null,
                            };
                        @endphp

                        <td class="border border-gray-300 dark:border-gray-700 p-3">
                            @if($route)
                                <a class="text-blue-600 dark:text-blue-400 hover:underline"
                                   href="{{ route($route , $comment->commentable->slug) }}">
                                    {{ $comment->commentable->title }}
                                </a>
                            @else
                                {{ $comment->commentable->title }}
                            @endif
                        </td>

                        <!-- متن -->
                        <td class="border border-gray-300 dark:border-gray-700 p-3">
                            {{ $comment->body }}
                        </td>

                        <!-- تاریخ -->
                        <td class="border border-gray-300 dark:border-gray-700 p-3">
                            {{ $comment->created_at->diffForHumans() }}
                        </td>

                        <!-- Accept -->
                        <td class="border border-gray-300 dark:border-gray-700 p-3 text-center">
                            <div>
                                <button wire:click="accept({{ $comment->id }})" class="bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white px-4 py-1 rounded-xl transition">
                                    تایید
                                </button>
                            </div>
                        </td>

                        <!-- Delete -->
                        <td class="border border-gray-300 dark:border-gray-700 p-3 text-center">
                            <div class="inline-block">
                                <button wire:click="delete({{ $comment->id }})" class="bg-red-500 hover:bg-red-600 dark:bg-red-700 dark:hover:bg-red-800 text-white px-4 py-1 rounded-xl transition">
                                    حذف
                                </button>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 mx-auto max-w-4xl">
        {{ $comments->links() }}
    </div>

</main>
