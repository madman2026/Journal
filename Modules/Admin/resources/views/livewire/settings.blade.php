<main class="p-6 md:p-8 bg-gray-50 dark:bg-gray-900 min-h-screen">

    <form wire:submit.prevent="updateSections"
        class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md space-y-8 text-gray-900 dark:text-gray-100">

        <h2 class="text-2xl font-semibold text-center text-blue-600 dark:text-blue-400">
            تغییر صفحه اصلی و ابزارها
        </h2>

        {{-- دسته‌بندی‌ها --}}
        <section class="p-4 rounded-xl shadow-xl bg-gray-100 dark:bg-gray-700">
            <h3 class="text-xl font-semibold mb-3">دسته‌بندی‌ها</h3>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mb-4">
                @foreach ($categories as $category)
                    <div
                        class="p-3 bg-gray-200 dark:bg-gray-600 rounded-xl text-center hover:bg-gray-300 dark:hover:bg-gray-500 transition">
                        {{ $category->name }}
                    </div>
                @endforeach
            </div>

            <x-core::form.text-input
                wire:model.lazy="new_category"
                label="دسته‌بندی جدید"
                name="category" />
            <button wire:click="addCategory"
                type="button"
                class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">
                افزودن
            </button>
        </section>

        <section class="p-4 rounded-xl shadow-xl bg-gray-100 dark:bg-gray-700">
            <h3 class="text-xl font-semibold mb-3">سطوح رویداد</h3>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mb-4">
                @foreach ($levels as $level)
                    <div
                        class="p-3 bg-gray-200 dark:bg-gray-600 rounded-xl text-center hover:bg-gray-300 dark:hover:bg-gray-500 transition">
                        {{ $level->name }}
                    </div>
                @endforeach
            </div>

            <x-core::form.text-input wire:model.lazy="new_level" label="سطح جدید" name="level" />

            <button wire:click="addLevel" type="button"
                class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">
                افزودن
            </button>
        </section>

        {{-- مدیریت سکشن‌ها --}}
        <section class="p-4 rounded-xl shadow-xl bg-gray-100 dark:bg-gray-700 space-y-4">
            <h3 class="text-xl font-semibold">اطلاعات بخش‌ها</h3>

            @foreach ($sections as $section)
                <div class="p-3 rounded-lg border bg-white dark:bg-gray-800 dark:border-gray-600">
                    <label class="text-lg mb-2 block">
                        {{ __("fields.$section->name") }}
                    </label>

                    @if (in_array($section->name, ['defaultContentImage', 'titleHeader', 'titleFooter']))
                        <x-core::form.file-input
                            :name='$section->name'
                            wire:model="sectionInputs.{{ $section->name }}"
                            label="آپلود تصویر جدید"
                            accept="image/*" />
                    @else
                        <p class="text-sm opacity-70 mb-2">متن فعلی: {{ $section->content }}</p>
                        <x-core::form.textarea
                            :name='$section->name'
                            :label='__("fields.$section->name")'
                            wire:model.lazy="sectionInputs.{{ $section->name }}"
                            placeholder="متن جدید را وارد کنید..." />
                    @endif
                </div>
            @endforeach
        </section>

        {{-- لینک جدید --}}
        <section class="p-4 rounded-xl shadow-xl bg-gray-100 dark:bg-gray-700 space-y-4">
            <h3 class="text-lg font-semibold">افزودن لینک مفید</h3>

            <x-core::form.text-input label="عنوان لینک" wire:model.lazy="new_link_name" name="linkName" />
            <x-core::form.text-input label="لینک" wire:model.lazy="new_link" name="link" />

            <button wire:click="addLink" type="button"
                class="bg-green-500 dark:bg-green-600 hover:bg-green-600 dark:hover:bg-green-700 text-white px-4 py-2 rounded-md">
                افزودن لینک
            </button>
        </section>

        <button type="submit"
            class="w-full bg-blue-500 dark:bg-blue-600 hover:bg-blue-600 dark:hover:bg-blue-700 text-white font-semibold p-3 rounded-md">
            ذخیره همه
        </button>
    </form>

    {{-- لینک‌های مفید --}}
    @if (!empty($links))
        <div class="mt-8 space-y-3">
            <h3 class="text-lg font-bold text-center text-gray-800 dark:text-gray-100">لینک‌های مفید</h3>

            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($links as $link)
                    <div class="p-4 rounded-xl shadow-xl bg-white dark:bg-gray-800 border dark:border-gray-600 flex flex-col gap-2">
                        <a href="{{ $link->link }}" rel="noopener"
                            class="text-blue-500 hover:underline font-semibold">
                            {{ $link->name }}
                        </a>

                        <button
                            wire:click="deleteLink({{ $link->id }})"
                            class="bg-red-500 dark:bg-red-600 hover:bg-red-600 dark:hover:bg-red-700 text-white px-3 py-1 rounded-md">
                            حذف
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</main>
