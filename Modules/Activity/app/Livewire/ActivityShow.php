<?php

namespace Modules\Activity\Livewire;

use Livewire\Component;
use Modules\Activity\Models\Activity;
use Modules\Core\App\Contracts\HasInteractableComponent;

class ActivityShow extends Component
{
    use HasInteractableComponent;
    public $content;
    public function mount(Activity $Activity)
    {
        $this->content = $Activity->load(['user', 'comments'])
            ->loadCount(['comments', 'likes', 'views']);

        $this->visitAction();
    }

    public function toggleLike()
    {
        $liked = $this->toggleLikeAction();

        $this->refreshStats();

        $this->dispatch('toastMagic',
            message: $liked ? 'لایک شد' : 'لایک حذف شد',
            title: 'موفقیت',
            status: 'success'
        );
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
