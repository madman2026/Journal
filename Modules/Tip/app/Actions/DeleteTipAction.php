<?php

namespace Modules\Tip\Actions;

use Modules\Tip\Models\Tip;

class DeleteTipAction
{
    public function handle(Tip $tip)
    {
        return $tip->delete();
    }
}
