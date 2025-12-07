<?php

namespace Modules\Activity\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Activity\Models\Activity;
use Modules\Activity\Services\ActivityService;

class ActivityDeleteController extends Controller
{
    public function __invoke(Activity $Activity, ActivityService $service): RedirectResponse
    {
        $result = $service->delete($Activity);

        if ($result->status) {
            return redirect()->route('activity.index')
                ->with('success', 'رویداد با موفقیت حذف شد');
        }

        return redirect()->back()
            ->with('error', 'خطا در حذف رویداد: '.$result->message);
    }
}
