<?php

namespace Modules\Core\Contracts;

use Illuminate\Support\Facades\Storage;

trait HasDownloadableContentComponent
{
    public function download($filePath)
    {
        return response()->download(Storage::disk('public')->path($filePath));
    }
}
