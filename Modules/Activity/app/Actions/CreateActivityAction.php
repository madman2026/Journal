<?php

namespace Modules\Activity\Actions;

use Modules\Activity\Models\Activity;

class CreateActivityAction
{
    public function handle(array $data)
    {
        return Activity::create($data);
    }
}
