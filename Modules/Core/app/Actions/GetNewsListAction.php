<?php

namespace Modules\Core\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Core\Models\News;

class GetNewsListAction
{
    public function handle(int $perPage = 20): LengthAwarePaginator
    {
        return News::with(['user'])
            ->withCount(['views', 'likers as likes_count'])
            ->latest()
            ->paginate($perPage);
    }
}
