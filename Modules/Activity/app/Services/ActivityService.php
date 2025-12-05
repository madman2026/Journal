<?php

namespace Modules\Activity\Services;

use Modules\Activity\Actions\CreateActivityAction;
use Modules\Activity\Actions\UpdateActivityAction;
use Modules\Activity\Models\Activity;
use Modules\Core\app\Contracts\BaseService;

class ActivityService extends BaseService
{
    public function __construct(private CreateActivityAction $createAction, private UpdateActivityAction $updateAction) {}

    public function create(array $data)
    {
        return $this->execute(function () use ($data) {
            return $this->createAction->handle($data);
        });
    }

    public function update(Activity $activity, array $data)
    {
        return $this->execute(function () use ($activity, $data) {
            return $this->updateAction->handle($activity, $data);
        });
    }
}
