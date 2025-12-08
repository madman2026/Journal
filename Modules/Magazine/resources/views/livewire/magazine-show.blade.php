
<!-- Magazine Show Blade Template Redesigned -->
<div class="min-h-screen p-6 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">

        <!-- Header Image -->
        <div class="relative">
            <img src="{{ asset($content->image) }}" alt="{{ $content->title }}" class="w-full object-cover max-h-[380px]">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                <h1 class="text-3xl font-bold text-white drop-shadow">{{ $content->title }}</h1>
            </div>
        </div>

        <!-- Body Content -->
        <div class="p-6 space-y-6">

            <!-- Metadata -->
            <div class="flex justify-between items-center text-sm text-gray-600 dark:text-gray-300">
                <span class="flex items-center gap-1">
                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                    نویسنده: <strong>{{ $content->user->username }}</strong>
                </span>
                <span class="flex items-center gap-1">
                    <x-heroicon-o-chat-bubble-left-right class="w-5 h-5" />
                    نظرات: {{ $content->comments_count }}
                </span>
            </div>

            <!-- Body Text -->
            <div class="text-gray-700 dark:text-gray-300 leading-7 whitespace-pre-line">
                {!! nl2br(e($content->body)) !!}
            </div>

            <!-- Attachment -->
            @if ($content->attachment)
                <div class="p-4 bg-blue-50 dark:bg-blue-900/40 border border-blue-200 dark:border-blue-700 rounded-xl flex items-start gap-3">
                    <x-heroicon-o-document class="w-7 h-7 text-blue-600 dark:text-blue-300" />
                    <div>
                        <h3 class="text-lg font-bold mb-1">📂 فایل نشریه</h3>
                        <x-table.file-download :filePath="$content->attachment" />
                    </div>
                </div>
            @endif

            <!-- Articles List -->
            @if ($content->articles->isNotEmpty())
                <div>
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <x-heroicon-o-circle-stack class="w-6 h-6" />
                        مقالات
                    </h3>

                    <ul class="bg-gray-100 dark:bg-gray-700 p-4 rounded-xl space-y-3">
                        @foreach ($content->articles as $index => $article)
                            <li class="flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <span>{{ $index + 1 }}.</span>
                                    <span class="text-blue-600 dark:text-orange-300 font-semibold">{{ $article->title }}</span>
                                </div>
                                @if ($article->attachment)
                                    <x-table.file-download :filePath="$article->attachment" />
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Stats & Like -->
            <div class="flex justify-between items-center pt-3 border-t border-gray-300/40 dark:border-gray-700/40">
                <span class="flex items-center gap-1 text-gray-600 dark:text-gray-300">
                    <x-heroicon-o-eye class="w-5 h-5" />
                    بازدید: {{ $content->views_count }}
                </span>

                <button wire:click="toggleLike()" class="flex items-center gap-1 px-4 py-2 bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white rounded-xl transition">
                    <x-heroicon-o-heart class="w-5 h-5" />
                    لایک: {{ $content->likes_count }}
                </button>
            </div>

            <!-- Categories -->
            <div class="flex flex-wrap justify-center mt-4 gap-2 text-sm">
                <x-heroicon-o-tag class="w-5 h-5" />
                @forelse ($categories as $category)
                    <span class="text-blue-600 dark:text-orange-300 underline">#{{ $category['name'] }}</span>
                @empty
                    <span class="text-gray-500 dark:text-gray-400">هیچ دسته‌بندی وجود ندارد</span>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Comments Section -->
    <section class="max-w-4xl mx-auto mt-10 p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl">
        <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
            <x-heroicon-o-chat-bubble-oval-left class="w-6 h-6" />
            نظرات
        </h2>

        @forelse ($content->comments as $comment)
            <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-xl">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                <p class="mt-2">{{ $comment->body }}</p>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400">هیچ نظری وجود ندارد.</p>
        @endforelse

        @auth
            <form wire:submit.prevent="makeComment()" class="mt-6 space-y-4">
                <x-core::form.textarea name="commentBody" label="نظر شما" required placeholder="متن نظر..." />
                <x-core::form.button type="submit" class="w-full">ارسال نظر</x-core::form.button>
            </form>
        @else
            <p class="text-center mt-5">
                <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-300 hover:underline">ورود برای ثبت نظر</a>
            </p>
        @endauth
    </section>

    <!-- Related Content -->
    <section class="max-w-4xl mx-auto mt-10 p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl">
        <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
            <x-heroicon-o-rectangle-group class="w-6 h-6" />
            محتوای مشابه
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse ($relateds as $related)
                <a href="{{ route('magazine.show', $related['slug']) }}" class="flex items-center bg-gray-100 dark:bg-gray-700 p-4 rounded-xl shadow-sm hover:shadow-md transition gap-3">
                    <img src="{{ asset($related['image']) }}" alt="{{ $related['title'] }}" class="w-16 h-16 object-cover rounded-lg">
                    <div class="truncate text-blue-600 dark:text-orange-300 font-semibold">{{ Str::limit($related['title'], 40) }}</div>
                </a>
            @empty
                <p class="text-gray-500 dark:text-gray-400">محتوای مشابهی یافت نشد.</p>
            @endforelse
        </div>
    </section>
</div>
