<main class="w-full transition-all flex flex-col gap-8">

    {{-- رویدادها --}}
    <x-section
        title="رویدادها"
        :items="$activities"
        type="activity"
        defaultLink="{{ route('activity.index') }}"
        containerClass="activity-swiper-container"
        emptyMessage="رویدادی موجود نیست"
        bgClass="bg-blue-300 dark:bg-darkPrimary"
    />

    {{-- نکات --}}
    <x-section
        title="نکات"
        :items="$tips"
        type="tip"
        defaultLink="{{ route('tip.index') }}"
        containerClass="tip-swiper-container"
        emptyMessage="نکته‌ای موجود نیست"
        bgClass="bg-blue-300 dark:bg-darkPrimary"
    />

    {{-- نشریات --}}
    <section class="mx-4">
        <a href="{{ route('magazine.index') }}"
           class="text-4xl font-bold hover:text-blue-600 dark:text-white block mb-4 text-center">
           نشریات
        </a>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">

            <div class="relative rounded-xl p-6 flex flex-col lg:col-span-4 lg:flex-row
                        bg-blue-300 dark:bg-darkPrimary items-center shadow-lg">
                @if($magazines->isNotEmpty())
                    <x-slider
                        :items="$magazines"
                        type="magazine"
                        defaultLink="{{ route('magazine.index') }}"
                        containerClass="magazine-swiper-container"
                    />
                @else
                    <p class="text-center text-gray-500 dark:text-gray-400 w-full">
                        نشریه‌ای موجود نیست
                    </p>
                @endif
            </div>

            <div class="p-4 dark:text-white rounded-xl bg-gray-400 dark:bg-slate-700 shadow-lg">
                <h3 class="text-xl font-bold mb-3">راهنمایی</h3>
                <p class="text-sm">
                    {{ $sections['magazineGuide']['content'] ?? 'راهنمایی موجود نیست' }}
                </p>
            </div>
        </div>
    </section>

</main>
