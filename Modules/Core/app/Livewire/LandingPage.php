<?php

namespace Modules\Core\Livewire;

use Livewire\Component;
use Modules\Core\Services\LandingPageService;

class LandingPage extends Component
{
    public $sections;
    public $events;
    public $magazines;
    public $news;
    public $isMobile;

    protected LandingPageService $service;

    public function boot(LandingPageService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $result = $this->service->getLandingPageData();

        if ($result->status && $result->data) {
            $this->sections = $result->data['sections'];
            $this->events = $result->data['events'];
            $this->magazines = $result->data['magazines'];
            $this->news = $result->data['news'];
            $this->isMobile = $result->data['isMobile'];
        } else {
            // Set defaults on error
            $this->sections = collect();
            $this->events = collect();
            $this->magazines = collect();
            $this->news = collect();
            $this->isMobile = false;
        }
    }

    public function render()
    {
        return view('core::livewire.landing-page');
    }
}

