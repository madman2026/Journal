<?php

namespace Modules\Magazine\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Magazine\Models\Magazine;
use Modules\Magazine\Services\MagazineService;

class MagazineDeleteController extends Controller
{
    public function __invoke(Magazine $Magazine, MagazineService $service): RedirectResponse
    {
        $result = $service->delete($Magazine);

        if ($result->status) {
            return redirect()->route('magazine.index')
                ->with('success', 'نشریه با موفقیت حذف شد');
        }

        return redirect()->back()
            ->with('error', 'خطا در حذف نشریه: '.$result->message);
    }
}
