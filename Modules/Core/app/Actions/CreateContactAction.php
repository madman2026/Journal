<?php

namespace Modules\Core\Actions;

use Illuminate\Support\Facades\Auth;
use Modules\Core\Models\Contact;

class CreateContactAction
{
    public function handle(array $data): Contact
    {
        if (Auth::check()) {
            return Auth::user()->contacts()->create($data);
        }

        return Contact::create($data);
    }

    public function rules(): array
    {
        return [
            'g-recaptcha-response' => 'required|captcha',
            'body' => 'required|min:10|max:10000|string',
            'phone' => 'required|numeric',
        ];
    }
}

