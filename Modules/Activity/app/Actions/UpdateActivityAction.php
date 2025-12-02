<?php

namespace Modules\Activity\Actions;

use Modules\Activity\Models\Activity;

class UpdateActivityAction
{
    public function handle(Activity $activity, array $data): array
    {
        // فقط فیلدهای مجاز
        $filtered = array_intersect_key($data, $activity->getFillable());

        // اگر هیچ چیزی تغییر نکرده باشه
        if (!$this->isChanged($activity, $filtered)) {
            return [
                'updated' => false,
                'model'   => $activity
            ];
        }

        // انجام آپدیت
        $activity->update($filtered);

        return [
            'updated' => true,
            'model'   => $activity->fresh()
        ];
    }

    private function isChanged(Activity $activity, array $data): bool
    {
        foreach ($data as $key => $value) {
            if ($activity->{$key} != $value) {
                return true;
            }
        }
        return false;
    }
}
