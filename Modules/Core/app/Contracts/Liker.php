<?php

namespace Modules\Core\Contracts;

use Modules\Interaction\Models\Like;

trait Liker
{
    public function likes()
    {
        return $this->morphMany(Like::class, 'user');
    }
    public function like($model)
    {
        return Like::firstOrCreate([
            'user_id'   => $this->id,
            'likeable_id' => $model->id,
            'likeable_type' => get_class($model),
        ]);
    }
    public function unlike($model)
    {
        return Like::where([
            'user_id'   => $this->id,
            'likeable_id' => $model->id,
            'likeable_type' => get_class($model),
        ])->delete();
    }
    public function hasLiked($model)
    {
        return Like::where([
            'user_id'   => $this->id,
            'likeable_id' => $model->id,
            'likeable_type' => get_class($model),
        ])->exists();
    }
    public function countLikes()
    {
        return $this->likes()->count();
    }
}
