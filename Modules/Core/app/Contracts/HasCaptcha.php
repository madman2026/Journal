<?php

namespace Modules\Core\App\Contracts;

use Livewire\Attributes\Validate;

trait HasCaptcha
{
    // #[Validate('required|captcha')]
    public $g_recaptcha_response;
}
