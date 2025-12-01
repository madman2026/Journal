<?php

namespace Modules\Core\Actions;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Core\Models\Event;

class GetEventsListAction
{
    public function handle(int $perPage = 20): LengthAwarePaginator
    {
        return Event::with(['user'])
            ->withCount(['views', 'likers as likes_count'])
            ->latest()
            ->paginate($perPage);
    }
}

