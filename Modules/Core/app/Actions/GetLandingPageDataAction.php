<?php

namespace Modules\Core\Actions;

use Illuminate\Support\Collection;
use Jenssegers\Agent\Facades\Agent;
use Modules\Core\Models\Event;
use Modules\Core\Models\News;
use Modules\Core\Models\Section;
use Modules\Magazine\Models\Magazine;

class GetLandingPageDataAction
{
    public function handle(): array
    {
        $isMobile = Agent::isMobile();

        // Fetch latest content with optimized queries
        $magazines = Magazine::select(['id', 'title', 'image', 'slug'])
            ->latest()
            ->limit(5)
            ->get();

        $events = Event::select(['id', 'title', 'image', 'slug'])
            ->latest()
            ->limit(5)
            ->get();

        $news = News::select(['id', 'title', 'image', 'slug'])
            ->latest()
            ->limit(5)
            ->get();

        // Get default image from sections
        $sections = Section::all()->keyBy('name');
        $defaultImage = $sections->get('defaultContentImage')->content ?? 'default-image-path.jpg';

        // Adjust slides using the default image
        $magazines = $this->adjustSlides($magazines, 3, $isMobile, $defaultImage);
        $events = $this->adjustSlides($events, 4, $isMobile, $defaultImage);
        $news = $this->adjustSlides($news, 4, $isMobile, $defaultImage);

        return [
            'sections' => $sections,
            'events' => $events,
            'magazines' => $magazines,
            'news' => $news,
            'isMobile' => $isMobile,
        ];
    }

    private function adjustSlides(Collection $items, int $limit, bool $isMobile, string $defaultImage): Collection
    {
        $count = $items->count();

        if (! $isMobile && $count < $limit) {
            $defaultSlide = [
                'title' => 'موسسه جواد الائمه',
                'image' => $defaultImage,
                'slug' => null,
                'body' => '',
                'is_default' => true,
            ];

            $items = $items->concat(array_fill(0, $limit - $count, $defaultSlide));
        }

        if ($isMobile && $count > $limit) {
            $items = $items->take($limit);
        }

        // Convert to arrays for consistency
        return $items->map(function ($item) {
            if (is_array($item)) {
                return $item;
            }
            return [
                'id' => $item->id,
                'title' => $item->title ?? '',
                'image' => $item->image ?? '',
                'slug' => $item->slug ?? null,
                'body' => $item->body ?? '',
            ];
        });
    }
}

