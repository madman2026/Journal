<?php

namespace Modules\Tip\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Core\Models\Category;
use Modules\Tip\Models\Tip;
use Modules\Tip\Services\TipService;

class TipEdit extends Component
{
    use WithFileUploads;

    public Tip $tip;

    #[Validate('nullable|array')]
    public $selectedCategories;

    #[Validate('required|string|min:1|max:100')]
    public $title;

    #[Validate('required|string|min:10|max:9999999')]
    public $body;

    #[Validate('nullable|image|max:10000')]
    public $image;

    public $categories = [];

    protected TipService $service;

    public function boot(TipService $service)
    {
        $this->service = $service;
    }

    public function mount(Tip $Tip)
    {
        $this->tip = $Tip;
        $this->title = $Tip->title;
        $this->body = $Tip->body;
        $this->selectedCategories = $Tip->categories()->pluck('id')->toArray();
        $this->categories = Category::all()->pluck('name', 'id');
    }

    public function render(): View
    {
        $this->categories = Category::all()->pluck('name', 'id');

        return view('tip::livewire.tip-edit');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updateTip()
    {
        $data = $this->validate();

        if ($this->image) {
            $data['image'] = $this->image->store('tips/images', 'public');
        }

        $result = $this->service->update($this->tip, $data);

        if ($result->status) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: 'موفقیت',
                message: 'نکته با موفقیت به‌روزرسانی شد'
            );

            return $this->redirectRoute('tip.show', ['Tip' => $this->tip->slug]);
        }

        $this->dispatch('toastMagic',
            status: 'error',
            title: 'خطا',
            message: 'مشکلی بوجود آمد: '.$result->message
        );
    }
}
