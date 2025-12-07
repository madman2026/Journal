<?php

namespace Modules\Tip\Livewire;

use Livewire\Component;
use Modules\Tip\Models\Tip;

class TipIndex extends Component
{
    public function render()
    {
        return view('tip::livewire.tip-index', [
            'tips' => Tip::query()
                ->with(['user', 'categories'])
                ->withCount(['likes', 'views', 'comments'])
                ->orderByDesc('updated_at')
                ->paginate(10),
        ]);
    }
}
