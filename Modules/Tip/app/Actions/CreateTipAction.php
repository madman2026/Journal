<?php

namespace Modules\Tip\Actions;

use Modules\Tip\Models\Tip;

class CreateTipAction
{
    public function handle(array $data): Tip
    {
        $data['user_id'] = auth()->id();

        $categories = $data['selectedCategories'] ?? [];
        unset($data['selectedCategories']);

        $tip = Tip::create($data);

        if (! empty($categories)) {
            $tip->categories()->sync($categories);
        }

        return $tip;
    }
}
