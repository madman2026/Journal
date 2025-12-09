<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;
use Modules\Activity\Models\Activity;
use Modules\Core\Models\Section;
use Modules\Magazine\Models\Magazine;
use Modules\Tip\Models\Tip;

class Home extends Component
{
    public Collection $activities;
    public Collection $tips;
    public Collection $magazines;
    public Collection $sections;

    public function mount()
    {
        $this->activities = $this->ensureMinimumItems(
            Activity::latest()->take(10)->get(),
            4,
            'activity'
        );

        $this->tips = $this->ensureMinimumItems(
            Tip::latest()->take(10)->get(),
            4,
            'tip'
        );

        $this->magazines = $this->ensureMinimumItems(
            Magazine::latest()->take(10)->get(),
            4,
            'magazine'
        );

        $this->sections = Section::where('name', 'magazineGuide')
            ->get()
            ->mapWithKeys(fn($section) => [
                $section->name => collect(['content' => $section->content])
            ]);
    }

    private function ensureMinimumItems($items, int $min, string $type)
    {
        $items = collect($items); // force plain collection
        $count = $items->count();

        if ($count < $min) {
            for ($i = $count; $i < $min; $i++) {
                $items->push([
                    'slug' => null,
                    'image' => Section::whereName('defaultContentImage')->first()->content,
                    'title' => 'موسسه عالی معصومیه',
                ]);
            }
        }

        return $items;
    }


    public function render()
    {
        return view('livewire.home');
    }
}
