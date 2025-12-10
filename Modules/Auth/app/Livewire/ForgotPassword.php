<?php

namespace Modules\Auth\Livewire;

use DutchCodingCompany\LivewireRecaptcha\ValidatesRecaptcha;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Auth\Services\AuthService;
use Modules\Core\Contracts\HasCaptcha;

class ForgotPassword extends Component
{
    use HasCaptcha;

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

    #[ValidatesRecaptcha]
    public function forgotPassword()
    {
        $result = $this->service->forgotPassword($this->validate());

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

    public function render(): View
    {
        return view('auth::livewire.forgot-password');
    }
}
