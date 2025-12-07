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
        $this->content = $Activity->load(['user', 'comments'])
            ->loadCount(['comments', 'likes', 'views']);

        $this->initializeHasLiked();
        $this->visitAction();
    }

    public function refreshStats()
    {
        $this->content->loadCount(['comments', 'likes', 'views']);
    }

    public function render()
    {
        return view('activity::livewire.activity-show');
    }
}
