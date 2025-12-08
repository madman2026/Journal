    <main class="flex justify-center py-8">
        <form wire:submit.prevent="save" enctype="multipart/form-data"
              class="container flex flex-col gap-6 p-8 bg-white shadow-lg rounded-lg max-w-lg w-full">
            <x-core::form.text-input
                label="عنوان"
                name="title"
                type="text"
                wire="title"
                placeholder="عنوان نشریه پیشنهادی خود را وارد کنید"
            />
            <x-core::form.file-input
                label="PDF"
                name="pdf"
                wire="pdf"
            />
            <div>
                <label for="word" class="block text-sm font-medium text-gray-700">فایل مقاله به صورت (Word)</label>
                @error('word')
                    <div class="text-red-500 text-sm mt-1" id="error-word">{{ $message }}</div>
                @enderror
                <input type="file" accept=".docx" name="word" id="word" aria-describedby="error-word"
                        class="mt-1 block w-full focus:outline-none transition-all border border-gray-300 rounded-md p-2 focus:ring focus:ring-blue-400">
            </div>
            <div>
                <button type="submit"
                        class="w-full bg-blue-500 text-white font-semibold p-2 rounded-md hover:bg-blue-600 transition duration-200">
                    ثبت
                </button>
            </div>
        </form>
    </main>
