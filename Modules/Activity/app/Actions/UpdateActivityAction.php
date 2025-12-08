<?php

namespace Modules\Activity\Actions;

use Illuminate\Support\Facades\Storage;
use Modules\Activity\Models\Activity;

class UpdateActivityAction
{
    public function handle(Activity $activity, array $data): Activity
    {
        if (!empty($data['image'])) {
            if ($activity->image && Storage::disk('public')->exists($activity->image)) {
                Storage::disk('public')->delete($activity->image);
            }
        } else {
            unset($data['image']);
        }

        if (!empty($data['attachment'])) {
            if ($activity->attachment && Storage::disk('public')->exists($activity->attachment)) {
                Storage::disk('public')->delete($activity->attachment);
            }
        } else {
            unset($data['attachment']);
        }

        $categories = $data['selectedCategories'] ?? null;
        unset($data['selectedCategories']);

        $filtered = array_intersect_key($data, array_flip($activity->getFillable()));

        $activity->update($filtered);

        if ($categories !== null) {
            $activity->categories()->sync($categories);
        }

        return $activity->fresh();
    }

}
