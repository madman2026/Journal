<div class="w-full max-w-full">
    {!! NoCaptcha::renderJs('fa') !!}
    {!! NoCaptcha::display(['data-theme' => 'dark']) !!}
    @error("g_recaptcha_response")
    <span class="text-red-500 text-sm mt-1">
            {{$message}}
        </span>
    @enderror
</div>
