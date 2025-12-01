<div>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold mb-6 dark:text-white text-center">تماس با ما</h1>

            <form wire:submit="save" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 space-y-6">

                {{-- Phone Input --}}
                <x-core::form.text-input label='تلفن همراه' name="phone" id="phone" type="tel"
                    placeholder="09123456789" />

                <x-core::form.textarea name="body" label="متن" id="body" rows="6"
                    placeholder="پیام خود را بنویسید..." />
                <x-captcha />

                {{-- Submit Button --}}
                <div class="flex justify-end">
                    <x-core::form.button type="submit" class="px-6 py-2">
                        ارسال پیام
                    </x-core::form.button>
                </div>
            </form>
        </div>
    </div>
</div>
