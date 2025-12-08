<div class="min-h-screen p-5 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <div class="p-5">

            <img src="{{ asset($content->image) }}" alt="{{ $content->title }}" class="w-full h-full max-h-144 object-cover"
                >
            <!-- Title -->
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100" >
                {{ $content->title }}
            </h1>

            <!-- Meta -->
            <div class="flex items-center justify-between mt-2">
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    نویسنده: {{ $content->user->username }}
                </span>
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    تعداد نظرات: {{ $content->comments_count }}
                </span>
            </div>
            @if ($content->attachment)
                <x-table.file-download :filePath="$content->attachment" />
            @endif
            <!-- Abstract -->
            <p class="mt-4 text-gray-700 dark:text-gray-300 leading-7" >
                <span class="font-bold text-lg">چکیده</span><br>
                {!! nl2br(e($content->abstract)) !!}
            </p>

            <!-- Body -->
            <p class="mt-6 text-gray-700 dark:text-gray-300 leading-8 text-right" >
                <span class="font-bold text-lg">متن</span><br>
                {!! nl2br(e($content->body)) !!}
            </p>

            <!-- Like + Views -->
            <div class="flex items-center justify-between mt-6">

                <span class="text-sm text-gray-500 dark:text-gray-400">
                    بازدید: {{ $content->views_count }}
                </span>

                <x-core::form.button
                    wire:click="toggleLike()"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    <x-heroicon-o-heart class=" w-5 h-5"/> {{ $content->likes_count }}
                </x-core::form.button>

            </div>

        </div>
    </div>

    <!-- Comments Section -->
    <section id="comments"
             class="max-w-4xl mx-auto mt-10 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-5"
             >

        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">نظرات</h2>

        @forelse ($content->comments as $comment)
            <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $comment->created_at->diffForHumans() }}
                </p>

                <p class="mt-2 text-gray-900 dark:text-gray-100">
                    {{ $comment->body }}
                </p>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400 mt-5">هیچ نظری وجود ندارد.</p>
        @endforelse

        @auth
            <form wire:submit.prevent="makeComment()" class="mt-6 space-y-4">
                <x-core::form.textarea
                    name="commentBody"
                    label="متن"
                    required
                    placeholder="نظر خود را وارد کنید..."
                />

                <x-core::form.button type="submit" class="w-full">
                    ارسال
                </x-core::form.button>
            </form>
        @else
            <p class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">
                    ورود برای ثبت نظر
                </a>
            </p>
        @endauth
    </section>

    <!-- Related Articles Section -->
    <section class="max-w-4xl mx-auto mt-10 p-5 bg-white dark:bg-gray-800 rounded-xl shadow-lg"
             >

        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">محتواهای مشابه</h2>

        <div class="mt-5 space-y-4">
            @if (!empty($relateds))
                @foreach ($relateds as $related)
                    <div class="flex items-center bg-gray-100 gap-2 dark:bg-gray-700 p-3 rounded-lg">

                        <img src="{{ asset($related['image']) }}"
                             alt="{{ $related['title'] }}"
                             class="w-16 h-16 object-cover rounded-lg">

                        <div class="ml-4 space-y-1">
                            <a href="{{ route('activity.show', $related['slug']) }}"
                               class="text-blue-500 dark:text-orange-300 hover:underline">
                                {{ Str::limit($related['title'], 30) }}
                            </a>

                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ Str::limit($related['body'], 50) }}
                            </p>
                        </div>

                    </div>
                @endforeach
            @else
                <p class="text-gray-500 dark:text-gray-400">محتوای مشابهی یافت نشد.</p>
            @endif

        </div>
    </section>
</div>
