<?php

namespace Modules\Core\Contracts;

use Modules\Interaction\Services\InteractionService;

trait Interactable
{
    public function comments()
    {
        return $this->morphMany(\Modules\Interaction\Models\Comment::class, 'commentable');
    }

    public function views()
    {
        return $this->morphMany(\Modules\Interaction\Models\View::class, 'viewable');
    }

    public function likes()
    {
        return $this->morphMany(\Modules\Interaction\Models\Like::class, 'likeable');
    }

    public function interact()
    {
        return app(InteractionService::class);
    }
}
