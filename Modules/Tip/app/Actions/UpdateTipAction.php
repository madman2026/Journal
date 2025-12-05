<?php

namespace Modules\Tip\Actions;

use Modules\Tip\Models\Tip;

class UpdateTipAction
{
    public function handle(Tip $tip , array $data) {
        $tip->update($data);
    }
}
