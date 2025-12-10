<div class="w-full max-w-full">
    <div  wire:ignore>
        {!! NoCaptcha::renderJs('fa') !!}
        {!! NoCaptcha::display(['data-theme' => 'dark']) !!}
    </div>
    @error("g_recaptcha_response")
    <span class="text-red-500 text-sm mt-1">
            {{$message}}
        </span>
    @enderror
</div>
