<?php

namespace Modules\Tip\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Tip\Models\Tip;
use Modules\Tip\Services\TipService;

class TipDeleteController extends Controller
{
    public function __invoke(Tip $Tip, TipService $service): RedirectResponse
    {
        $result = $service->delete($Tip);

        if ($result->status) {
            return redirect()->route('tip.index')
                ->with('success', 'نکته با موفقیت حذف شد');
        }

        return redirect()->back()
            ->with('error', 'خطا در حذف نکته: '.$result->message);
    }
}
