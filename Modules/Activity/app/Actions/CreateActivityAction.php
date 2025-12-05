<?php

namespace Modules\Activity\Actions;

use Modules\Activity\Models\Activity;

class CreateActivityAction
{
    public function handle(array $data)
    {
        $data['user_id'] = auth()->id();
        return Activity::create($data);
    }
}
