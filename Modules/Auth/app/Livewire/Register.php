<?php

namespace Modules\Auth\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Auth\Services\AuthService;
use Modules\Core\Contracts\HasCaptcha;

class Register extends Component
{
    use HasCaptcha;

    public string $email = '';

    public string $password = '';

    public string $number = '';

    public string $password_confirmation = '';

    public string $username = '';

    protected AuthService $service;

    public function boot(AuthService $service): void
    {
        $this->service = $service;
    }

    public function rules(): array
    {
        return [
            'number' => 'required|digits_between:10,15|unique:users,number',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed',
            'username' => 'required|string|min:3|max:255|unique:users,username',
        ];
    }

    public function render(): View
    {
        return view('auth::livewire.register');
    }

    public function register()
    {
        $result = $this->service->register($this->validate());

        if ($result->status) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: '??? ??? ????',
                message: '????? ?? ?????? ????? ??.'
            );

            return redirect()->intended(route('user.profile'));
        }

        $this->addError('email', $result->message);
        $this->dispatch('toastMagic',
            status: 'error',
            title: '???',
            message: $result->message
        );
    }
}
