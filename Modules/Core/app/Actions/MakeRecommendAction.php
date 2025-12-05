<?php

namespace Modules\Core\Actions;

use Modules\Core\Livewire\Recommend;

class MakeRecommendAction
{
    public function handle($data)
    {
        try {
            Recommend::create($data);

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
