<?php

namespace Modules\Auth\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Auth\Services\AuthService;
use Modules\Core\Contracts\HasCaptcha;

class Login extends Component
{
    use HasCaptcha;

    public string $email = '';

    public string $password = '';

    protected AuthService $service;

    public function boot(AuthService $service): void
    {
        $this->service = $service;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|max:255',
        ];
    }

    public function render(): View
    {
        return view('auth::livewire.login');
    }

    public function login()
    {
        $result = $this->service->login($this->validate());

        if ($result->status) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: '???? ????',
                message: '????? ?? ?????? ???? ??.'
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
