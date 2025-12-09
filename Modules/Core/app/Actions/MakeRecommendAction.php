<?php

namespace Modules\Core\Actions;

use Modules\Core\app\Contracts\BaseService;

class MakeRecommendAction extends BaseService
{
    public function handle($data)
    {
        return $this->execute(fn () => auth()->user()->recommends()->create($data));
    }
}
