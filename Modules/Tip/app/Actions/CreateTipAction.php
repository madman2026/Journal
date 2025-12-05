<?php

namespace Modules\Tip\Actions;

use Modules\Tip\Models\Tip;

class CreateTipAction
{
    public function handle(array $data)
    {
        $data['user_id'] = auth()->id();
        return Tip::create($data);
    }
}
