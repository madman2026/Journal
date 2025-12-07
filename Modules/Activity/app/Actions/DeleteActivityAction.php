<?php

namespace Modules\Activity\Actions;

use Illuminate\Support\Facades\Storage;
use Modules\Activity\Models\Activity;

class DeleteActivityAction
{
    public function handle(Activity $activity): bool
    {
        // Delete associated files
        if ($activity->image && Storage::disk('public')->exists($activity->image)) {
            Storage::disk('public')->delete($activity->image);
        }

        if ($activity->attachment && Storage::disk('public')->exists($activity->attachment)) {
            Storage::disk('public')->delete($activity->attachment);
        }

        return $activity->delete();
    }
}
