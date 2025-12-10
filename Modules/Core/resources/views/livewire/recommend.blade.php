<main class="flex justify-center py-10 px-4 bg-gray-100 dark:bg-gray-900 min-h-screen">
    <form wire:submit.prevent="save" enctype="multipart/form-data"
          class="container flex flex-col gap-6 p-8 bg-white dark:bg-gray-800 shadow-xl rounded-2xl max-w-lg w-full
                 border border-gray-200 dark:border-gray-700 transition">

        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 text-center">ثبت نشریه جدید</h2>

        <x-core::form.text-input
            label="عنوان"
            name="title"
            type="text"
            wire="title"
            placeholder="عنوان نشریه پیشنهادی خود را وارد کنید"
            class="dark:bg-gray-700 dark:text-white dark:border-gray-600"
        />

        <x-core::form.file-input
            label="PDF"
            name="attachment"
            wire="attachment"
            accept="application/pdf"
            class="dark:bg-gray-700 dark:text-white dark:border-gray-600"
        />

        <x-core::form.file-input
            label="Word"
            name="word"
            wire="word"
            accept=".doc, .docx"
            class="dark:bg-gray-700 dark:text-white dark:border-gray-600"
        />

        <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-3 rounded-xl
                       hover:bg-blue-700 active:bg-blue-800 transition-all duration-200
                       focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
            ثبت
        </button>
    </form>
</main>
