<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Activity\Models\Activity;
use Modules\Core\Models\Section;
use Modules\Magazine\Models\Magazine;
use Modules\Tip\Models\Tip;

class Home extends Component
{
    private const DEFAULT_CONTENT_IMAGE = 'images/defaultContentImage.jpg';

    private const DEFAULT_CONTENT_TITLE = '????? ???? ???????';

    public Collection $activities;

    public Collection $tips;

    public Collection $magazines;

    public Collection $sections;

    public function mount(): void
    {
        $defaultImage = Section::where('name', 'defaultContentImage')->value('content') ?: self::DEFAULT_CONTENT_IMAGE;

        $this->activities = $this->ensureMinimumItems(
            Activity::latest()->take(10)->get(),
            4,
            $defaultImage
        );

        $this->tips = $this->ensureMinimumItems(
            Tip::latest()->take(10)->get(),
            4,
            $defaultImage
        );

        $this->magazines = $this->ensureMinimumItems(
            Magazine::latest()->take(10)->get(),
            4,
            $defaultImage
        );

        $this->sections = Section::where('name', 'magazineGuide')
            ->get()
            ->mapWithKeys(fn ($section) => [
                $section->name => collect(['content' => $section->content]),
            ]);
    }

    private function ensureMinimumItems(iterable $items, int $min, string $defaultImage): Collection
    {
        $items = collect($items);
        $count = $items->count();

        if ($count < $min) {
            for ($i = $count; $i < $min; $i++) {
                $items->push([
                    'slug' => null,
                    'image' => $defaultImage,
                    'title' => self::DEFAULT_CONTENT_TITLE,
                ]);
            }
        }

        return $items;
    }

    public function render(): View
    {
        return view('livewire.home');
    }
}
