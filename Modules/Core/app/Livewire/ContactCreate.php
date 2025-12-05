<?php

namespace Modules\Core\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\Core\App\Contracts\HasCaptcha;
use Modules\Core\Services\ContactService;

class ContactCreate extends Component
{
    use HasCaptcha;

    #[Validate('required|numeric')]
    public $phone = '';

    #[Validate('required|string|min:10|max:10000')]
    public $body = '';

    protected ContactService $service;

    public function boot(ContactService $service)
    {
        $this->service = $service;
    }

    public function save()
    {
        // Add recaptcha to validation
        $this->validate([
            'phone' => 'required|numeric',
            'body' => 'required|string|min:10|max:10000',
            'g_recaptcha_response' => 'required|captcha',
        ]);

        $result = $this->service->createContact([
            'phone' => $this->phone,
            'body' => $this->body,
            'g-recaptcha-response' => $this->g_recaptcha_response,
        ]);

        if ($result->status) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: 'ثبت شد',
                message: 'فرم با موفقیت ارسال شد'
            );

            // Reset form
            $this->reset(['phone', 'body', 'gRecaptchaResponse']);

            return redirect()->route('home');
        }

        $this->dispatch('toastMagic',
            status: 'error',
            title: 'خطا',
            message: $result->message ?? 'در ارسال فرم خطایی رخ داد'
        );
    }

    public function render()
    {
        return view('core::livewire.contact-create');
    }
}
