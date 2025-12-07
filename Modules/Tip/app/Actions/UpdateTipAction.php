<?php

namespace Modules\Tip\Actions;

use Illuminate\Support\Facades\Storage;
use Modules\Tip\Models\Tip;

class UpdateTipAction
{
    public function handle(Tip $tip, array $data): Tip
    {
        // Handle file deletion if new image is uploaded
        if (isset($data['image']) && $tip->image && Storage::disk('public')->exists($tip->image)) {
            Storage::disk('public')->delete($tip->image);
        }

        $categories = $data['selectedCategories'] ?? null;
        unset($data['selectedCategories']);

        $tip->update($data);

        if ($categories !== null) {
            $tip->categories()->sync($categories);
        }

        return $tip->fresh();
    }
}
