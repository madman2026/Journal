<?php

namespace Modules\Auth\Livewire;

use Livewire\Component;
use Modules\Auth\Services\AuthService;
use Modules\Core\Contracts\HasCaptcha;

class Login extends Component
{
    use HasCaptcha;

    public string $email = '';

    public string $password = '';

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|max:255',
        ];
    }

    protected AuthService $service;

    public function boot(AuthService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        return view('auth::livewire.login');
    }

    public function login()
    {
        $result = $this->service->login($this->validate());
        if ($result->status) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: 'ورود موفق',
                message: 'کاربر با موفقیت وارد شد.'
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
