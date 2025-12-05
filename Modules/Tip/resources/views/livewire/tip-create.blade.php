<main class="flex justify-center py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <form
        wire:submit.prevent="createTip"
        enctype="multipart/form-data"
        class="container flex flex-col gap-6 p-8 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-lg dark:shadow-lg/10 rounded-lg"
    >
        <x-core::form.text-input
            label="عنوان"
            placeholder="عنوان نکته را وارد کنید"
            name="title"
            :required="true"
            class="dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-300"
        />
            <x-core::form.select
                :options="$categories"
                label="دسته بندی"
                name="selectedCategories"
                :multiple="true"
                class="dark:bg-gray-700 dark:border-gray-600 dark:text-white"
            />

        <x-core::form.file-input
            label="عکس"
            placeholder="فایل تصویر"
            name="image"
            wire:model.lazy="image"
            :required="true"
            class="dark:bg-gray-700 dark:border-gray-600 dark:text-white"
        />

        <x-core::form.file-input
            label="PDF"
            placeholder="فایل PDF"
            name="attachment"
            wire:model.lazy="attachment"
            :required="false"
            class="dark:bg-gray-700 dark:border-gray-600 dark:text-white"
        />

        <x-core::form.textarea label="متن نکته" name="body" wire:model.lazy="body" placeholder="متن نکته را وارد کنید" :required="true" />
        <x-captcha />

        <div>
            <button
                type="submit"
                class="w-full bg-blue-500 dark:bg-blue-600 hover:bg-blue-600 dark:hover:bg-blue-700 text-white font-semibold p-2 rounded-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-400"
            >
                ثبت
            </button>
        </div>
    </form>
</main>
