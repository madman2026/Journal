<?php

namespace Modules\Activity\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Modules\Activity\Models\Activity;

class ActivityIndex extends Component
{
    public function render(): View
    {
        return view('activity::livewire.activity-index', [
            'activities' => Activity::query()
                ->with(['user', 'level', 'categories'])
                ->withCount(['likes', 'views', 'comments'])
                ->orderByDesc('updated_at')
                ->paginate(10),
        ]);
    }
}
