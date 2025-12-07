<?php

namespace Modules\Tip\Livewire;

use Livewire\Component;
use Modules\Tip\Models\Tip;
use Modules\Core\Contracts\HasInteractableComponent;

class TipShow extends Component
{
    use HasInteractableComponent;

    public $content;

    public function mount(Tip $Tip)
    {
        $this->content = $Tip
            ->load([
                'user',
                'comments' => fn($q) => $q->where('status', true)
                ])
            ->loadCount([
                'comments' => fn($q) => $q->where('status', true),
                'likes',
                'views']);

        $this->initializeHasLiked(); // از Trait
        $this->visitAction();        // از Trait
    }

    public function refreshStats()
    {
        $this->content->loadCount([
            'comments' => fn($q) => $q->where('status', true),
            'likes',
            'views',
        ]);
    }

    public function render()
    {
        return view('tip::livewire.tip-show');
    }
}
