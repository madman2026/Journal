<?php

namespace Modules\Auth\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Auth\Services\AuthService;
use Modules\Core\Contracts\HasCaptcha;

class ResetPassword extends Component
{
    use HasCaptcha;

    public string $password = '';

    public string $password_confirmation = '';

    protected AuthService $service;

    public function boot(AuthService $service): void
    {
        $this->service = $service;
    }

    public function rules(): array
    {
        return [
            'password' => 'required|string|min:8|max:255|confirmed',
        ];
    }

    public function resetPassword()
    {
        $result = $this->service->resetPassword($this->validate());

        if ($result->status) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: '??????',
                message: '??? ???? ?? ?????? ????? ???.'
            );

            return redirect()->intended(route('login'));
        }

        $this->dispatch('toastMagic',
            status: 'error',
            title: '???',
            message: $result->message ?? '????? ??? ???? ?? ??? ????? ??.'
        );
    }

    public function render(): View
    {
        return view('auth::livewire.reset-password');
    }
}
