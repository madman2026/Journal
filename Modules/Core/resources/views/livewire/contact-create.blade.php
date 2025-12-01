<div>
    <x-layouts.app>
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-2xl mx-auto">
                <h1 class="text-3xl font-bold mb-6 dark:text-white text-center">تماس با ما</h1>

                <form wire:submit="save" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 space-y-6">
                    @csrf

                    {{-- Phone Input --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            شماره تماس
                        </label>
                        <x-core::form.text-input
                            wire:model="phone"
                            id="phone"
                            type="tel"
                            placeholder="09123456789"
                            :error="$errors->first('phone')"
                        />
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Body/Message Input --}}
                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            پیام
                        </label>
                        <x-core::form.textarea
                            wire:model="body"
                            id="body"
                            rows="6"
                            placeholder="پیام خود را بنویسید..."
                            :error="$errors->first('body')"
                        />
                        @error('body')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- reCAPTCHA --}}
                    <div>
                        <div class="g-recaptcha" data-sitekey="{{ config('captcha.site_key') }}"></div>
                        @error('gRecaptchaResponse')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex justify-end">
                        <x-core::form.button type="submit" class="px-6 py-2">
                            ارسال پیام
                        </x-core::form.button>
                    </div>
                </form>
            </div>
        </div>
    </x-layouts.app>
</div>

@push('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
