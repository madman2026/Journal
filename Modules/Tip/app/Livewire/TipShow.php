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
        $this->content = $Tip->load([
            'user',
            'categories',
        ])->loadCount([
            'likes',
            'views',
            'comments' => fn ($q) => $q->where('status', true),
        ]);

        $this->loadComments();         // فقط کامنت‌های تایید شده
        $this->initializeHasLiked();
        $this->visitAction();

        $this->relateds = Tip::whereHas('categories', function ($q) {
            $q->whereIn('categories.id', $this->content->categories->pluck('id'));
        })
            ->where('id', '!=', $this->content->id)
            ->with('categories')
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('tip::livewire.tip-show');
    }
}
