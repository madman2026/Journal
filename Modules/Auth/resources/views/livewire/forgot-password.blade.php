
<div class="flex items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8">
    <form wire:submit.prevent="forgotPassword" class="bg-slate-800 rounded-2xl shadow-xl w-full max-w-md p-6 space-y-6">
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
            <x-core::link
                href="{{ route('register') }}"
                text="ثبت نام"
                class="text-sm font-medium text-blue-400 hover:text-blue-300"
            />

            <x-core::link
                href="{{ route("login") }}"
                text="ورود"
                class="text-sm font-medium text-blue-400 hover:text-blue-300"
            />
        </div>
        <x-captcha/>
        <div class="flex justify-end">
            <x-core::form.button type="submit" class="px-6 py-2">
                ارسال
            </x-core::form.button>
        </div>
    </form>
</div>
