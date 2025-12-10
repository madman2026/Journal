<div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
    <form wire:submit.prevent="login" wire:recaptcha
          class="w-full max-w-md bg-slate-800 rounded-2xl shadow-xl p-6 space-y-6">
          @if($errors->has('gRecaptchaResponse'))
          <p class="text-red-500 dark:text-red-400 text-sm mt-1 flex items-center gap-1">
              <x-heroicon-o-exclamation-triangle class="w-4 h-4" />
              <span>{{ $errors->first('gRecaptchaResponse') }}</span>
          </p>
      @endif
        <x-core::form.text-input
            label="ایمیل"
            name="email"
            type="email"
            placeholder="ایمیل خود را وارد کنید"
        />

        <x-core::form.text-input
            label="رمز عبور"
            name="password"
            type="password"
            placeholder="رمز عبور خود را وارد کنید"
        />

        <div class="flex items-center justify-between">
            <x-core::link
                href="{{ route('register') }}"
                text="ثبت نام"
                class="text-sm font-medium text-blue-400 hover:text-blue-300"
            />

            <x-core::link
                href="{{ route('forgot-password') }}"
                text="فراموشی رمز عبور"
                class="text-sm font-medium text-blue-400 hover:text-blue-300"
            />
        </div>


        <div class="flex justify-end">
            <x-core::form.button type="submit" class="px-6 py-2">
                ورود
            </x-core::form.button>
        </div>
    </form>
</div>
@push('scripts')
    @livewireRecaptcha
@endpush
