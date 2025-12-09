<?php

namespace Modules\Core\Actions;

use Illuminate\Support\Facades\Storage;
use Modules\Core\Models\Recommend;

class DeleteRecommendAction
{
    public function handle(Recommend $recommend): bool
    {
        // Delete associated image file
        if ($recommend->word && Storage::disk('public')->exists($recommend->word)) {
            Storage::disk('public')->delete($recommend->word);
        }
        if ($recommend->attachment && Storage::disk('public')->exists($recommend->attachment)) {
            Storage::disk('public')->delete($recommend->attachment);
        }

        return $recommend->delete();
    }
}
