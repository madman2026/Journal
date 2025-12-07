<?php

namespace Modules\Tip\Actions;

use Illuminate\Support\Facades\Storage;
use Modules\Tip\Models\Tip;

class DeleteTipAction
{
    public function handle(Tip $tip): bool
    {
        // Delete associated image file
        if ($tip->image && Storage::disk('public')->exists($tip->image)) {
            Storage::disk('public')->delete($tip->image);
        }

        return $tip->delete();
    }
}
