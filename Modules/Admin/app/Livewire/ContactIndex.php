<?php

namespace Modules\Admin\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Core\Models\Contact;

class ContactIndex extends Component
{
    use WithFileUploads;

    public function delete($id)
    {
        Contact::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('admin::livewire.contact-index', [
            'contacts' => Contact::latest()->paginate(10),
        ]);
    }
}
