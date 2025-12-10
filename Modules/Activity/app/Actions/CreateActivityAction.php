<?php

namespace Modules\Activity\Actions;

use Modules\Activity\Models\Activity;

class CreateActivityAction
{
    public function handle(array $data): Activity
    {
        $userId = auth()->id();

        $data['user_id'] = $userId;

        $categories = $data['selectedCategories'] ?? [];
        unset($data['selectedCategories']);

        $levelId = $data['level'] ?? null;
        unset($data['level']);

        $activity = Activity::create($data);

        if (!empty($categories)) {
            $activity->categories()->sync($categories);
        }

        if ($levelId) {
            $activity->level()->associate($levelId);
            $activity->save();
        }

        return $activity;
    }
}
