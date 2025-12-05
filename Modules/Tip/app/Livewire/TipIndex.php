<?php

namespace Modules\Tip\Livewire;

use Livewire\Component;
use Modules\Tip\Models\Tip;

class TipIndex extends Component
{
    public function render()
    {
        return view('tip::livewire.index' , [
            'tips' => Tip::orderByDesc('updated_at')->paginate(10),
        ]);
    }
}
