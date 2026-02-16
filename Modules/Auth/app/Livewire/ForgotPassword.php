<?php

namespace Modules\Auth\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Auth\Services\AuthService;
use Modules\Core\Contracts\HasCaptcha;

class ForgotPassword extends Component
{
    use HasCaptcha;

    public string $email = '';

    public string $number = '';

    public string $password = '';

    public string $password_confirmation = '';

    protected AuthService $service;

    public function boot(AuthService $service): void
    {
        $this->service = $service;
    }

    protected function rules(): array
    {
        return [
            'email' => 'required|email',
            'number' => 'required|digits_between:10,15',
            'password' => 'required|string|min:8|max:255|confirmed',
        ];
    }

    public function forgotPassword()
    {
        $result = $this->service->forgotPassword($this->validate());

        if ($result->status) {
            $this->dispatch(
                'toastMagic',
                status: 'success',
                title: '??????',
                message: '??? ???? ?? ?????? ??????? ??'
            );

            return $this->redirectRoute('home');
        }

        $this->dispatch(
            'toastMagic',
            status: 'error',
            title: '???',
            message: $result->message ?? '??????? ?? ??? ????? ??'
        );
    }

    public function render(): View
    {
        return view('auth::livewire.forgot-password');
    }
}
