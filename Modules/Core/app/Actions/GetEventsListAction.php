<?php

namespace Modules\Core\Actions;

use Modules\Activity\Models\Activity;

class GetEventsListAction
{
    public function handle(int $perPage = 20)
    {
        return Activity::query()
            ->with(['user', 'level'])
            ->latest()
            ->paginate($perPage);
    }
}
