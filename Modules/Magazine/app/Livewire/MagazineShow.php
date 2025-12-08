<?php

namespace Modules\Magazine\Livewire;

use Livewire\Component;
use Modules\Core\Contracts\HasInteractableComponent;
use Modules\Magazine\Models\Magazine;
use Modules\Magazine\Services\MagazineService;

class MagazineShow extends Component
{
    use HasInteractableComponent;

    public $content;      // Model
    public $categories = []; // تبدیل Collection به array قابل استفاده در Livewire
    public $relateds = [];   // لیست نشریات مرتبط

    public MagazineService $service;

    public function boot(MagazineService $service)
    {
        $this->service = $service;
    }

    public function mount(Magazine $Magazine)
    {
        $result = $this->service->get($Magazine);
        if (! $result->status) {
            $this->dispatch('toastMagic',
                status: 'error',
                title: 'خطا!',
                message: 'نشریه پیدا نشد!'
            );

            return $this->redirectRoute('home');
        }
        $this->content     = $result->data['magazine'];
        $this->categories  = $result->data['categories'];
        $this->relateds    = $result->data['relateds'];

        $this->content->load([
            'user',
            'comments' => fn($q) => $q->where('status', true),
        ]);

        $this->initializeHasLiked();
        $this->visitAction();

        $this->refreshStats();
    }

    public function refreshStats()
    {
        if (! $this->content) {
            return;
        }

        $this->content->loadCount([
            'comments' => fn ($q) => $q->where('status', true),
            'views',
            'likes',
        ]);
    }

    public function render()
    {
        return view('magazine::livewire.magazine-show');
    }
}
