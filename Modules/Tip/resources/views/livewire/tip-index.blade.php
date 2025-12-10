
<main class="w-full p-5">
    <div class="grid p-4 gap-4 rounded-2xl bg-blue-300 dark:bg-darkPrimary xl:grid-cols-5 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 max-sm:grid-cols-1">
        @foreach ($tips as $item)
            <div wire:key="tip-{{ $item->id }}" class="col-span-1 p-4 rounded-xl bg-blue-400 dark:bg-emerald-800 shadow-md transition-transform transform hover:scale-105 hover:shadow-lg duration-300 animate-fadeIn">
                <a href="{{ route('tip.show', $item->slug) }}">
                    <img src="{{ asset($item->image) }}" alt="{{ $item->title }}"
                        class="w-full h-48 rounded-xl object-cover mb-4" loading="lazy">
                </a>
                <a href="{{ route('tip.show', $item->slug) }}"
                    class="text-lg font-bold text-lightText dark:text-darkText hover:text-secondary transition-colors">
                    {{ Illuminate\Support\Str::limit($item->title, 40) }}
                </a>
                <p class="text-sm mt-2 text-lightText/80 dark:text-darkText/70">
                    نویسنده: {{ $item->user->username ?? 'نامشخص' }}
                </p>
                <div class="flex justify-between mt-4 text-sm text-lightText/70 dark:text-darkText/60">
                    <p>بازدیدها: {{ $item->views_count ?? 0 }}</p>
                    <p>لایک‌ها: {{ $item->likes_count ?? 0 }}</p>
                </div>
            </div>
        @endforeach
        <div class="col-span-full flex justify-center mt-6">
            {{ $tips->links() }}
        </div>
    </div>
</main>

