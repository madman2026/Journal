<?php

namespace Modules\Activity\Livewire;

use Livewire\Component;
use Modules\Activity\Models\Activity;

class ActivityIndex extends Component
{
    public function render()
    {
        return view('activity::livewire.activity-index', [
            'activities' => Activity::orderByDesc('updated_at')->with('user')->withCount(['likes', 'views'])->paginate(10),
        ]);
    }
}
