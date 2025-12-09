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

    public $relateds;

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
        $this->relateds = Activity::whereHas('categories', function ($q) {
            $q->whereIn('categories.id', $this->content->categories->pluck('id'));
        })
            ->where('id', '!=', $this->content->id)
            ->limit(10)
            ->get();
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
