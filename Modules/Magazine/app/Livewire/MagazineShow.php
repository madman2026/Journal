<?php

namespace Modules\Magazine\Livewire;

use Livewire\Component;
use Modules\Core\Contracts\HasInteractableComponent;
use Modules\Magazine\Models\Magazine;
use Modules\Magazine\Services\MagazineService;

class MagazineShow extends Component
{
    use HasInteractableComponent;

    public Magazine $magazine;

    public $relateds = [];

    public $categories = [];

    public MagazineService $service;

    public function boot(MagazineService $service)
    {
        $this->service = $service;
    }

    public function mount(Magazine $magazine)
    {
        $result = $this->service->get($magazine);

        if (! $result->status) {
            $this->dispatch('toastMagic', status: 'error', title: 'خطا!', message: 'نشریه پیدا نشد!');
            $this->redirectRoute('home');
        }

        $this->magazine = $result->data['magazine'];
        $this->categories = $result->data['categories'];
        $this->relateds = $result->data['relateds'];

        // برای Trait تعاملات
        $this->content = $this->magazine;
        $this->initializeHasLiked();
    }

    public function refreshStats()
    {
        $this->magazine->loadCount([
            'comments' => fn ($q) => $q->where('status', true),
            'views',
            'likes',
        ]);
    }

    public function render()
    {
        // ثبت بازدید
        $this->visitAction();

        return view('magazine::livewire.magazine-show');
    }
}
