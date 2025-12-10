
    <div class="flex items-center justify-center min-h-screen px-4 py-4  sm:px-6 lg:px-8">
        <form wire:submit.prevent="register" wire:recaptcha class="bg-slate-800 rounded-2xl mt-20 shadow-xl w-full max-w-md p-6 space-y-6">
            @if($errors->has('gRecaptchaResponse'))
            <p class="text-red-500 dark:text-red-400 text-sm mt-1 flex items-center gap-1">
                <x-heroicon-o-exclamation-triangle class="w-4 h-4" />
                <span>{{ $errors->first('gRecaptchaResponse') }}</span>
            </p>
        @endif
            <x-core::form.text-input
                label="نام کاربری"
                name="username"
                type="text"
                :required="true"
                placeholder="نام کاربری خود را وارد کنید"
            />
            <x-core::form.text-input
                label="ایمیل"
                name="email"
                type="email"
                placeholder="ایمیل خود را وارد کنید"
            />
            <x-core::form.text-input
                label="شماره تماس"
                name="number"
                type="number"
                placeholder="شماره تماس خود را وارد کنید"
            />
            <x-core::form.text-input
                label="رمز عبور"
                name="password"
                type="password"
                placeholder="رمز عبور خود را وارد کنید"
            />
            <x-core::form.text-input
                label="تکرار رمز عبور"
                name="password_confirmation"
                type="password"
                placeholder="رمز عبور خود را دوباره وارد کنید"
            />
            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm font-medium text-blue-400 hover:text-blue-300">ورود</a>
            </div>
            <div class="flex justify-end">
                <x-core::form.button type="submit" class="px-6 py-2">
                    ثبت نام
                </x-core::form.button>
            </div>
        </form>
    </div>
    @push('scripts')
    @livewireRecaptcha
@endpush
