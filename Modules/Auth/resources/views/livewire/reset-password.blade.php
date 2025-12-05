<div class="flex items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8">
    <form wire:submit.prevent="resetPassword" class="bg-slate-800 rounded-2xl shadow-xl w-full max-w-md p-6 space-y-6">
        <x-core::form.text-input
            label="رمز عبور"
            name="password"
            type="password"
            wire="password"
            placeholder="رمز عبور خود را وارد کنید"
        />
        <x-core::form.text-input
            label="تکرار رمز عبور"
            name="password_confirmation"
            type="password"
            wire="password_confirmation"
            placeholder="رمز عبور خود را دوباره وارد کنید"
        />
        <x-captcha/>
        <div class="flex justify-end">
            <x-core::form.button type="submit" class="px-6 py-2">
                ثبت نام
            </x-core::form.button>
        </div>
    </form>
</div>
