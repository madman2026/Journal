<?php

namespace Modules\Auth\Livewire;

use Livewire\Component;
use Modules\Auth\Services\AuthService;
use Modules\Core\Contracts\HasCaptcha;

class Register extends Component
{
    // use HasCaptcha;

    public string $email = '';

    public string $password = '';

    public string $number = '';

    public string $password_confirmation = '';

    public string $username = '';

    public function rules()
    {
        return [
            'number' => 'required|numeric|min:10|unique:users,number',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed',
            'username' => 'required|string|unique:users',
        ];
    }

    protected AuthService $service;

    public function boot(AuthService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        return view('auth::livewire.register');
    }

    public function register()
    {
        $result = $this->service->register($this->validate());
        if ($result->status) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: 'ثبت نام موفق',
                message: 'کاربر با موفقیت ایجاد شد.'
            );

            return redirect()->intended(route('user.profile'));
        }

        $this->addError('email', $result->message);
        $this->dispatch('toastMagic',
            status: 'error',
            title: 'خطا',
            message: $result->message
        );
    }
}
