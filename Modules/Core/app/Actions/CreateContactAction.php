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
}
