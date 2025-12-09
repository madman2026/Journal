<?php

namespace Modules\Core\Actions;

use Modules\Core\app\Contracts\BaseService;
use Modules\Core\Livewire\Recommend;

class MakeRecommendAction extends BaseService
{
    public function handle($data)
    {
        return $this->execute(fn () => auth()->user()->recommends()->create($data));
    }
}
