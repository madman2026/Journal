<?php

namespace Modules\Activity\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Activity\Models\Activity;
use Modules\Activity\Models\Level;
use Modules\Activity\Services\ActivityService;
use Modules\Core\Models\Category;

class ActivityEdit extends Component
{
    use WithFileUploads;

    public Activity $activity;

    #[Validate('nullable|array')]
    public $selectedCategories;

    #[Validate('required|numeric|exists:levels,id')]
    public $level;

    #[Validate('required|string|min:1|max:100')]
    public $title;

    #[Validate('required|string|min:10|max:9999999')]
    public $body;

    #[Validate('nullable|file|mimes:pdf|max:10000')]
    public $attachment;

    #[Validate('nullable|image|max:10000')]
    public $image;

    public $levels = [];

    public $categories = [];

    protected ActivityService $service;

    public function boot(ActivityService $service)
    {
        $this->service = $service;
    }

    public function mount(Activity $Activity)
    {
        $this->activity = $Activity;
        $this->title = $Activity->title;
        $this->body = $Activity->body;
        $this->level = $Activity->level_id;
        $this->selectedCategories = $Activity->categories()->pluck('id')->toArray();
        $this->categories = Category::all()->pluck('name', 'id');
        $this->levels = Level::all()->keyBy('id')->pluck('name')->toArray();
    }

    public function render()
    {
        $this->categories = Category::all()->pluck('name', 'id');
        $this->levels = Level::all()->keyBy('id')->pluck('name')->toArray();

        return view('activity::livewire.activity-edit');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updateActivity()
    {
        $data = $this->validate();
        if ($this->image) {
            $data['image'] = $this->image->store('activities/images', 'public');
        }

        if ($this->attachment) {
            $data['attachment'] = $this->attachment->store('activities/attachments', 'public');
        }

        $result = $this->service->update($this->activity, $data);

        if ($result->status) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: 'موفقیت',
                message: 'رویداد با موفقیت به‌روزرسانی شد'
            );

            return $this->redirectRoute('activity.show', ['Activity' => $this->activity->slug]);
        }

        $this->dispatch('toastMagic',
            status: 'error',
            title: 'خطا',
            message: 'مشکلی بوجود آمد: '.$result->message
        );
    }
}
