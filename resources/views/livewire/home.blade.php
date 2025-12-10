<main class="w-full flex flex-col gap-8 transition-all">

    {{-- رویدادها --}}
    <x-section
        title="رویدادها"
        :items="$activities"
        type="activity"
        defaultLink="{{ route('activity.index') }}"
        containerClass="activity-swiper-container"
        emptyMessage="رویدادی موجود نیست"
        bgClass="bg-blue-100 dark:bg-darkPrimary"
    />

    {{-- نکات --}}
    <x-section
        title="نکات"
        :items="$tips"
        type="tip"
        defaultLink="{{ route('tip.index') }}"
        containerClass="tip-swiper-container"
        emptyMessage="نکته‌ای موجود نیست"
        bgClass="bg-blue-100 dark:bg-darkPrimary"
    />

    {{-- نشریات --}}
    <section class="mx-4">
        <a href="{{ route('magazine.index') }}"
           class="block text-3xl sm:text-4xl font-bold text-center text-gray-800 dark:text-white
                  hover:text-blue-600 transition-colors mb-6">
           نشریات
        </a>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">

            <div class="relative rounded-xl p-6 flex flex-col lg:flex-row lg:col-span-4
                        bg-blue-50 dark:bg-darkPrimary items-center shadow-md transition-shadow
                        hover:shadow-lg">
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

            <div class="p-5 rounded-xl bg-gray-100 dark:bg-slate-700 shadow-md text-gray-800 dark:text-white">
                <h3 class="text-xl font-semibold mb-3">راهنمایی</h3>
                <p class="text-sm leading-relaxed">
                    {{ $sections['magazineGuide']['content'] ?? 'راهنمایی موجود نیست' }}
                </p>
            </div>
        </div>
    </section>

</main>
