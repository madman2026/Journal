<?php

namespace Modules\Core\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Core\Actions\GetEventsListAction;

class EventsIndex extends Component
{
    use WithPagination;

    protected GetEventsListAction $action;

    public function boot(GetEventsListAction $action)
    {
        $this->action = $action;
    }

    public function render()
    {
        $events = $this->action->handle($this->perPage ?? 20);

        return view('core::livewire.events-index', [
            'events' => $events,
        ]);
    }
}

