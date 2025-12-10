<?php

namespace Modules\Tip\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Core\Models\Category;
use Modules\Tip\Services\TipService;

class TipCreate extends Component
{
    use WithFileUploads;

    #[Validate('nullable|array')]
    public $selectedCategories;

    #[Validate('required|string|min:1|max:100')]
    public $title;

    #[Validate('required|string|min:10|max:9999999')]
    public $body;

    #[Validate('required|image|max:10000')]
    public $image;

    public $categories = [];

    protected TipService $service;

    public function boot(TipService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->categories = Category::all()->pluck('name', 'id');
    }

    public function render(): View
    {
        $this->categories = Category::all()->pluck('name', 'id');

        return view('tip::livewire.tip-create');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createTip()
    {
        $data = $this->validate();
        if ($this->image) {
            $data['image'] = $this->image->store('tips/images', 'public');
        }

        $result = $this->service->create($data);

        if ($result->status) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: 'موفقیت',
                message: 'نکته با موفقیت ایجاد شد'
            );
            $this->reset();
        } else {
            $this->dispatch('toastMagic',
                status: 'error',
                title: 'خطا',
                message: 'مشکلی بوجود آمد:'.$result->message
            );
        }
    }
}
