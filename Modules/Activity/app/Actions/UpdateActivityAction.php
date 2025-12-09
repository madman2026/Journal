<?php

namespace Modules\Activity\Actions;

use Illuminate\Support\Facades\Storage;
use Modules\Activity\Models\Activity;

class UpdateActivityAction
{
    public function handle(Activity $activity, array $data): Activity
    {
        // Handle image
        if (! empty($data['image'])) {
            $this->deleteOldFile($activity->image);
        } else {
            unset($data['image']);
        }

        // Handle attachment
        if (! empty($data['attachment'])) {
            $this->deleteOldFile($activity->attachment);
        } else {
            unset($data['attachment']);
        }

        // Extract special fields
        $categories = $data['selectedCategories'] ?? null;
        unset($data['selectedCategories']);

        $level = $data['level'] ?? null;
        unset($data['level']);

        // Keep only fillable attributes
        $filtered = array_intersect_key($data, array_flip($activity->getFillable()));

        // Update main data
        $activity->update($filtered);

        // Sync categories (many-to-many)
        if ($categories !== null) {
            $activity->categories()->sync($categories);
        }

        // Handle level (belongsTo or many-to-many?)
        if ($level !== null) {
            if (method_exists($activity->level(), 'sync')) {
                $activity->level()->sync($level); // many-to-many
            } else {
                $activity->level()->associate($level); // belongsTo
                $activity->save();
            }
        }

        return $activity->fresh();
    }

    private function deleteOldFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
