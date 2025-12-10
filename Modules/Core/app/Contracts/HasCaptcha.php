<?php

namespace Modules\Core\Contracts;

use Livewire\Attributes\Validate;

trait HasCaptcha
{
    #[Validate('required|captcha')]
    public $g_recaptcha_response;
}
