<?php

namespace Modules\Core\Actions;

use Modules\Activity\Models\Activity;
use Modules\Core\Models\Section;
use Modules\Magazine\Models\Magazine;
use Modules\Tip\Models\Tip;

class GetLandingPageDataAction
{
    public function handle(): array
    {
        return [
            'activities' => Activity::latest()->take(10)->get(),
            'tips' => Tip::latest()->take(10)->get(),
            'magazines' => Magazine::latest()->take(10)->get(),
            'sections' => Section::query()->pluck('content', 'name')->toArray(),
        ];
    }
}
