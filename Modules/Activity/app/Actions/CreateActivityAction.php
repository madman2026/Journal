<?php

namespace Modules\Activity\Actions;

use Modules\Activity\Models\Activity;

class CreateActivityAction
{
    public function handle(array $data): Activity
    {
        $data['user_id'] = auth()->id();

        $categories = $data['selectedCategories'] ?? [];
        unset($data['selectedCategories']);

        $activity = Activity::create($data);

        if (! empty($categories)) {
            $activity->categories()->sync($categories);
        }

        return $activity;
    }
}
