<?php

namespace Modules\Activity\Livewire;

use Livewire\Component;
use Modules\Activity\Models\Activity;
use Modules\Core\App\Contracts\HasDownloadableContentComponent;
use Modules\Core\Contracts\HasInteractableComponent;

class ActivityShow extends Component
{
    use HasDownloadableContentComponent
        , HasInteractableComponent;

    public $content;

    public function mount(Activity $Activity)
    {
        $this->content = $Activity
            ->load([
                'user',
                'level',
                'comments' => fn ($q) => $q->where('status', true),
            ])
            ->loadCount([
                'comments' => fn ($q) => $q->where('status', true),
                'likes',
                'views',
            ]);

        $this->initializeHasLiked();
        $this->visitAction();
    }

    public function refreshStats()
    {
        $this->content->loadCount([
            'comments' => fn ($q) => $q->where('status', true),
            'likes',
            'views',
        ]);
    }

    public function render()
    {
        return view('activity::livewire.activity-show');
    }
}
