<?php

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Modules\User\Models\User;

class LoginAction
{
    public function handle(array $data)
    {
        $user = User::whereEmail($data['email'])->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        if (! Auth::attempt($data, true)) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        return true;
    }
}
