<?php

namespace Modules\Activity\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\Activity\Models\Activity;
use Modules\Activity\Models\Level;
use Modules\Activity\Services\ActivityService;
use Modules\Core\Models\Category;

class ActivityCreate extends Component
{
    #[Validate('nullable|array')]
    public $categories;
    #[Validate('required|numeric|exists:levels,id')]
    public $levels;
    #[Validate('required|string')]
    public $title;
    #[Validate('required|string|min:10|max:9999999')]
    public $body;
    #[Validate('required|file|mimes:.pdf|max:10000')]
    public $attachment;
    #[Validate('required|image|max:10000')]
    public $image;

    protected  ActivityService $service;

    public function boot(ActivityService $service)
    {
        $this->service = $service;
    }
    public function mount()
    {
        $this->categories = Category::all()->pluck("name","id");
        $this->levels = Level::all()->toArray();
    }

    public function render()
    {
        return view('activity::livewire.activity-create');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function createActivity()
    {
        $result = $this->service->create($this->validate());

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
