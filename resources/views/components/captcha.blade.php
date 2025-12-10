<div class="w-full max-w-full">
    {!! NoCaptcha::renderJs('fa') !!}
    {!! NoCaptcha::display(['data-theme' => 'dark', 'wire:model' => 'gRecaptchaResponse']) !!}
    @error('gRecaptchaResponse')
        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
    @enderror
</div>
