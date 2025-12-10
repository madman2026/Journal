<?php

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Auth;

class LogoutAction
{
    public function handle(): bool
    {
        Auth::guard('web')->logout();

        return true;
    }
}
