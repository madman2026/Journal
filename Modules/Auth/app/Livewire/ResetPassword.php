<?php

namespace Modules\Auth\Livewire;

use DutchCodingCompany\LivewireRecaptcha\ValidatesRecaptcha;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Auth\Services\AuthService;
use Modules\Core\Contracts\HasCaptcha;

class ResetPassword extends Component
{
    use HasCaptcha;

    public $password;

    public $password_confirmation;

    public function rules()
    {
        return [
            'password' => 'required|string|min:6|max:255|confirmed',
        ];
    }

    protected AuthService $service;

    public function boot(AuthService $service)
    {
        $this->service = $service;
    }

    #[ValidatesRecaptcha]
    public function resetPassword()
    {
        $result = $this->service->resetPassword($this->validate());
        
        if ($result->status) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: 'موفقیت',
                message: 'رمز عبور با موفقیت تغییر کرد.'
            );

            return redirect()->intended(route('login'));
        }
        
        $this->dispatch('toastMagic',
            status: 'error',
            title: 'خطا',
            message: $result->message ?? 'تغییر رمز عبور با خطا مواجه شد.'
        );
    }

    public function render(): View
    {
        return view('auth::livewire.reset-password');
    }
}
