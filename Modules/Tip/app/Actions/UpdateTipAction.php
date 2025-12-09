<?php

namespace Modules\Tip\Actions;

use Illuminate\Support\Facades\Storage;
use Modules\Tip\Models\Tip;

class UpdateTipAction
{
    public function handle(Tip $tip, array $data): Tip
    {
        // Extract categories and remove from main data
        $categories = $data['selectedCategories'] ?? null;
        unset($data['selectedCategories']);

        // Handle image safely
        if (! empty($data['image'])) {
            // Delete previous image AFTER confirming new exists
            $this->deleteOldFile($tip->image);
        } else {
            // Prevent accidental overriding with null
            unset($data['image']);
        }

        // Finally update tip
        $tip->update($data);

        // Update categories
        if ($categories !== null) {
            $tip->categories()->sync($categories);
        }

        return $tip->fresh();
    }

    private function deleteOldFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
