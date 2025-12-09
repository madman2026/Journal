<?php

namespace Modules\Auth\Actions;

use Auth;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;

class RegisterAction
{
    public function handle(array $data): User
    {

        $user = User::create([
            'username' => $data['username'],
            'number' => $data['number'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('user');
        Auth::login($user);

        return $user;
    }
}
