<?php

namespace Modules\Activity\Livewire;

use Livewire\Component;
use Modules\Activity\Models\Activity;

class ActivityIndex extends Component
{
    public function render()
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
