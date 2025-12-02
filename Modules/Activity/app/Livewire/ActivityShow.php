<?php

namespace Modules\Activity\Livewire;

use Livewire\Component;
use Modules\Activity\Models\Activity;

class ActivityShow extends Component
{
    public $activity;
    public function mount(Activity $Activity)
    {
        $this->activity = $Activity->load(['user' , 'comments'])->loadCount(['comments' , 'likes' , 'views']);
    }
    public function render()
    {
        return view('activity::livewire.activity-show');
    }
}
