<?php

namespace Modules\Auth\Livewire;

use Livewire\Component;
use Modules\Auth\Services\AuthService;

class ForgotPassword extends Component
{
    public $email;

    public $number;

    public $password;

    public $password_confirmation;

    protected AuthService $service;

    public function boot(AuthService $service)
    {
        $this->service = $service;
    }

    protected function rules()
    {
        return [
            'email' => 'required|email',
            'number' => 'required|numeric',
            'password' => 'required|string|min:6|max:50|confirmed',
        ];
    }

    public function forgotPassword()
    {

        $result = $this->service->forgotPassword($this->validate());
        dd($result);
        if ($result->status) {
            $this->dispatch(
                'toastMagic',
                status: 'success',
                title: 'موفقیت',
                message: 'رمز عبور با موفقیت بازیابی شد'
            );

            return $this->redirectRoute('home');
        }

        $this->dispatch(
            'toastMagic',
            status: 'error',
            title: 'خطا',
            message: $result->message ?? 'بازیابی با خطا مواجه شد'
        );
    }

    public function render()
    {
        return view('auth::livewire.forgot-password');
    }
}
