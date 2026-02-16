<?php

namespace Modules\Core\Actions;

use Modules\Magazine\Models\Magazine;

class GetNewsListAction
{
    public function handle(int $perPage = 20)
    {
        return Magazine::query()
            ->with('user')
            ->latest()
            ->paginate($perPage);
    }
}
