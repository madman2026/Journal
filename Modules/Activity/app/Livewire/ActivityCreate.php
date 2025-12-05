<?php

namespace Modules\Activity\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Activity\Models\Activity;
use Modules\Activity\Models\Level;
use Modules\Activity\Services\ActivityService;
use Modules\Core\Models\Category;

class ActivityCreate extends Component
{
    use WithFileUploads;
    #[Validate('nullable|array')]
    public $selectedCategories;
    #[Validate('required|numeric|exists:levels,id')]
    public $level;
    #[Validate('required|string|min:1|max:100')]
    public $title;
    #[Validate('required|string|min:10|max:9999999')]
    public $body;
    #[Validate('required|file|mimes:pdf|max:10000')]
    public $attachment;
    #[Validate('required|image|max:10000')]
    public $image;
    public $levels = [];
    public $categories = [];
    protected  ActivityService $service;

    public function boot(ActivityService $service)
    {
        $this->service = $service;
    }
    public function mount()
    {
        $this->categories = Category::all()->pluck("name","id");
        $this->levels = Level::all()->keyBy('id')->pluck('name')->toArray();
    }

    public function render()
    {
        $this->categories = Category::all()->pluck("name","id");
        $this->levels = Level::all()->pluck('name')->toArray();
        return view('activity::livewire.activity-create');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function createActivity()
    {
        $data = $this->validate();
        if ($this->image) {
            $data['image'] = $this->image->store('activities/images', 'public');
        }

        if ($this->attachment) {
            $data['attachment'] = $this->attachment->store('activities/attachments', 'public');
        }

        $result = $this->service->create($data);

        if ($result->status) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: 'موفقیت',
                message: 'رویداد با موفقیت ایجاد شد'
            );
            $this->reset();
        }else{
            $this->dispatch('toastMagic',
                status: 'error',
                title: 'خطا',
                message: 'مشکلی بوجود آمد:'. $result->message
            );
        }
    }
}
