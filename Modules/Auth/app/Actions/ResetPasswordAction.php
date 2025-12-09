<?php

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResetPasswordAction
{
    public function handle(array $data)
    {
        $user = Auth::user();

        if (! $user) {
            throw ValidationException::withMessages([
                'auth' => __('auth.unauthenticated'),
            ]);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return $user;
    }
}
