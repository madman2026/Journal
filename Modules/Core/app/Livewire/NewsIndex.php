<?php

namespace Modules\Core\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Core\Actions\GetNewsListAction;

class NewsIndex extends Component
{
    use WithPagination;

    protected GetNewsListAction $action;

    public function boot(GetNewsListAction $action)
    {
        $this->action = $action;
    }

    public function render()
    {
        $news = $this->action->handle($this->perPage ?? 20);

        return view('core::livewire.news-index', [
            'news' => $news,
        ]);
    }
}

