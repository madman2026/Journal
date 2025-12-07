<?php

namespace Modules\Activity\Actions;

use Illuminate\Support\Facades\Storage;
use Modules\Activity\Models\Activity;

class UpdateActivityAction
{
    public function handle(Activity $activity, array $data): Activity
    {
        // Handle file deletion if new files are uploaded
        if (isset($data['image']) && $activity->image && Storage::disk('public')->exists($activity->image)) {
            Storage::disk('public')->delete($activity->image);
        }

        if (isset($data['attachment']) && $activity->attachment && Storage::disk('public')->exists($activity->attachment)) {
            Storage::disk('public')->delete($activity->attachment);
        }

        $categories = $data['selectedCategories'] ?? null;
        unset($data['selectedCategories']);

        // فقط فیلدهای مجاز
        $filtered = array_intersect_key($data, array_flip($activity->getFillable()));

        $activity->update($filtered);

        if ($categories !== null) {
            $activity->categories()->sync($categories);
        }

        return $activity->fresh();
    }
}
