<?php

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\User\Models\User;

class ForgotPasswordAction
{
    public function handle(array $data)
    {
        $user = User::where('email', $data['email'])
            ->where('number', $data['number'])
            ->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return $user;
    }
}
