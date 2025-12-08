<?php

namespace Modules\Tip\Livewire;

use Livewire\Component;
use Modules\Core\Contracts\HasInteractableComponent;
use Modules\Tip\Models\Tip;

class TipShow extends Component
{
    use HasInteractableComponent;

    public $content;
    public $relateds;

    public function mount(Tip $Tip)
    {
        $this->content = $Tip
            ->load([
                'user',
                'comments' => fn ($q) => $q->where('status', true),
            ])
            ->loadCount([
                'comments' => fn ($q) => $q->where('status', true),
                'likes',
                'views']);
        $this->relateds = Tip::whereHas('categories', function ($q) {
                $q->whereIn('categories.id', $this->content->categories->pluck('id'));
            })
            ->where('id', '!=', $this->content->id)
            ->limit(10)
            ->get();
        $this->initializeHasLiked(); // از Trait
        $this->visitAction();        // از Trait
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
        return view('tip::livewire.tip-show');
    }
}
