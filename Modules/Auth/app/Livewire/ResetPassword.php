<?php

namespace Modules\Auth\Livewire;

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

    public function save()
    {
        $result = $this->service->resetPassword($this->validate());
        if ($result->status) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: 'ثبت نام موفق',
                message: 'کاربر با موفقیت ایجاد شد.'
            );

            return redirect()->intended(route('user.profile'));
        }
        $this->dispatch('toastMagic',
            status: 'error',
            title: 'ثبت نام ناموفق',
            message: 'مشکلی پیش آمد.'
        );
    }

    public function render()
    {
        return view('auth::livewire.reset-password');
    }
}
