<?php

namespace Modules\Magazine\Actions;

use Illuminate\Support\Facades\Storage;
use Modules\Magazine\Models\Magazine;

class DeleteMagazineAction
{
    public function handle(Magazine $magazine): bool
    {
        // Delete associated image file
        if ($magazine->image && Storage::disk('public')->exists($magazine->image)) {
            Storage::disk('public')->delete($magazine->image);
        }
        if ($magazine->attachment && Storage::disk('public')->exists($magazine->attachment)) {
            Storage::disk('public')->delete($magazine->attachment);
        }

        return $magazine->delete();
    }
}
