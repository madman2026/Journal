<main class="flex justify-center py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <form
        wire:submit.prevent="updateActivity"
        enctype="multipart/form-data"
        class="container flex flex-col gap-6 p-8 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-lg dark:shadow-lg/10 rounded-lg"
    >
        <x-core::form.text-input
            label="عنوان"
            placeholder="عنوان رویداد را وارد کنید"
            name="title"
            wire:model="title"
            :required="true"
            class="dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-300"
        />

        <div class="grid justify-items-center grid-cols-2 max-lg:grid-cols-1 max-lg:gap-2 lg:gap-5">
            <x-core::form.select
                :options="$levels"
                label="سطح رویداد"
                :required="true"
                name="level"
                wire:model="level"
                class="dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            />

            <x-core::form.select
                :options="$categories"
                label="دسته بندی"
                name="selectedCategories"
                wire:model="selectedCategories"
                :multiple="true"
                class="dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            />
        </div>

        @if($activity->image)
            <div class="flex items-center gap-4">
                <img src="{{ asset($activity->image) }}" alt="{{ $activity->title }}" class="w-32 h-32 object-cover rounded">
                <span class="text-sm text-gray-600 dark:text-gray-400">عکس فعلی</span>
            </div>
        @endif

        <x-core::form.file-input
            label="عکس جدید (اختیاری)"
            placeholder="فایل تصویر"
            name="image"
            accept="image/*"
            wire:model.lazy="image"
            :required="false"
            class="dark:bg-gray-700 dark:border-gray-600 dark:text-white"
        />

        @if($activity->attachment)
            <div class="flex items-center gap-4">
                <a href="{{ asset($activity->attachment) }}" target="_blank" class="text-blue-500 hover:underline">
                    فایل PDF فعلی
                </a>
            </div>
        @endif

        <x-core::form.file-input
            label="PDF جدید (اختیاری)"
            placeholder="فایل PDF"
            name="attachment"
            accept="application/pdf"
            wire:model.lazy="attachment"
            :required="false"
            class="dark:bg-gray-700 dark:border-gray-600 dark:text-white"
        />

        <x-core::form.textarea
            label="متن رویداد"
            name="body"
            wire:model.lazy="body"
            placeholder="متن رویداد را وارد کنید"
            :required="true"
        />

        <div>
            <button
                type="submit"
                class="w-full bg-blue-500 dark:bg-blue-600 hover:bg-blue-600 dark:hover:bg-blue-700 text-white font-semibold p-2 rounded-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-400"
            >
                به‌روزرسانی
            </button>
        </div>
    </form>
</main>
