<main class="p-6 md:p-10 bg-gray-100 dark:bg-gray-900 min-h-screen">

    <form wire:submit.prevent="updateSections"
        class="max-w-5xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-xl shadow-gray-300/20 dark:shadow-black/20 space-y-10 text-gray-900 dark:text-gray-100">

        <h2 class="text-3xl font-bold text-center text-blue-600 dark:text-blue-400 mb-4 tracking-tight">
            مدیریت صفحه اصلی و ابزارها
        </h2>

        {{-- دسته‌بندی‌ها --}}
        <section class="p-6 rounded-2xl bg-gray-50 dark:bg-gray-700/40 shadow-md shadow-gray-300/20 dark:shadow-black/30 space-y-4">
            <h3 class="text-xl font-semibold mb-2">دسته‌بندی‌ها</h3>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($categories as $category)
                    <div
                        class="p-4 bg-gray-200 dark:bg-gray-600 rounded-2xl flex flex-col items-center justify-between gap-3 hover:shadow-md hover:-translate-y-1 transition-all duration-200">

                        <span class="font-medium">{{ $category->name }}</span>

                        <button
                            wire:click="delCategory({{ $category->id }})"
                            class="bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white px-4 py-1.5 rounded-lg text-sm shadow-sm">
                            حذف
                        </button>

                    </div>
                @endforeach
            </div>

            <div class="space-y-3 pt-2">
                <x-core::form.text-input wire:model.lazy="new_category" label="دسته‌بندی جدید" name="category" />

                <button type="button" wire:click="addCategory"
                    class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 px-5 py-2 text-white rounded-xl shadow-sm transition">
                    افزودن
                </button>
            </div>
        </section>



        {{-- سطوح --}}
        <section class="p-6 rounded-2xl bg-gray-50 dark:bg-gray-700/40 shadow-md shadow-gray-300/20 dark:shadow-black/30 space-y-4">
            <h3 class="text-xl font-semibold mb-2">سطوح رویداد</h3>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($levels as $level)
                    <div
                        class="p-4 bg-gray-200 dark:bg-gray-600 rounded-2xl flex flex-col items-center justify-between gap-3 hover:shadow-md hover:-translate-y-1 transition-all duration-200">

                        <span class="font-medium">{{ $level->name }}</span>

                        <button wire:click="delLevel({{ $level->id }})"
                            class="bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white px-4 py-1.5 rounded-lg text-sm shadow-sm">
                            حذف
                        </button>
                    </div>
                @endforeach
            </div>

            <div class="space-y-3 pt-2">
                <x-core::form.text-input wire:model.lazy="new_level" label="سطح جدید" name="level" />

                <button type="button" wire:click="addLevel"
                    class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 px-5 py-2 text-white rounded-xl shadow-sm transition">
                    افزودن
                </button>
            </div>
        </section>



        {{-- سکشن‌ها --}}
        <section class="p-6 rounded-2xl bg-gray-50 dark:bg-gray-700/40 shadow-md shadow-gray-300/20 dark:shadow-black/30 space-y-5">
            <h3 class="text-xl font-semibold">اطلاعات بخش‌ها</h3>

            @foreach ($sections as $section)
                <div class="p-4 rounded-xl border border-gray-300/60 dark:border-gray-600 bg-white dark:bg-gray-800 shadow-sm">
                    <label class="text-lg font-medium mb-3 block">
                        {{ __("fields.$section->name") }}
                    </label>

                    @if (in_array($section->name, ['defaultContentImage', 'titleHeader', 'titleFooter']))
                        <x-core::form.file-input
                            name="sectionInputs.{{ $section->name }}"
                            label="آپلود تصویر جدید"
                            accept="image/*" />
                    @else
                        <p class="text-sm opacity-70 mb-3">متن فعلی: {{ $section->content }}</p>

                        <x-core::form.textarea
                            name='sectionInputs.{{ $section->name }}'
                            :label='__("fields.$section->name")'
                            placeholder="متن جدید را وارد کنید..." />
                    @endif
                </div>
            @endforeach
        </section>



        {{-- لینک جدید --}}
        <section class="p-6 rounded-2xl bg-gray-50 dark:bg-gray-700/40 shadow-md shadow-gray-300/20 dark:shadow-black/30 space-y-4">
            <h3 class="text-xl font-semibold">افزودن لینک مفید</h3>

            <x-core::form.text-input
                label="عنوان لینک"
                wire:model.lazy="new_link_name"
                name="linkName" />

            <x-core::form.text-input
                label="لینک"
                wire:model.lazy="new_link"
                name="link" />

            <button type="button"
                wire:click="addLink"
                class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 px-5 py-2 text-white rounded-xl shadow-sm transition">
                افزودن لینک
            </button>
        </section>


        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 text-white font-semibold p-3 rounded-xl shadow-lg shadow-blue-500/20 dark:shadow-blue-800/20 transition">
            ذخیره همه
        </button>

    </form>



    {{-- لینک‌ها --}}
    @if (!empty($links))
        <div class="mt-10 space-y-4 max-w-5xl mx-auto">
            <h3 class="text-xl font-bold text-center">لینک‌های مفید</h3>

            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach ($links as $link)
                    <div
                        class="p-5 rounded-2xl bg-white dark:bg-gray-800 border border-gray-300/70 dark:border-gray-600 shadow-md hover:-translate-y-1 hover:shadow-lg transition-all flex flex-col gap-3">

                        <a href="{{ $link->link }}" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                            {{ $link->name }}
                        </a>

                        <button
                            wire:click="deleteLink({{ $link->id }})"
                            class="bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white px-4 py-1.5 rounded-lg text-sm shadow-sm">
                            حذف
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</main>
