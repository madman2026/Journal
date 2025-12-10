<?php

namespace Modules\Core\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Interaction\Models\Like;

trait Liker
{
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function like($model)
    {
        return Like::firstOrCreate([
            'user_id' => $this->id,
            'likeable_id' => $model->id,
            'likeable_type' => get_class($model),
        ]);
    }

    public function unlike($model)
    {
        return Like::where([
            'user_id' => $this->id,
            'likeable_id' => $model->id,
            'likeable_type' => get_class($model),
        ])->delete();
    }

    public function hasLiked($model)
    {
        return Like::where([
            'user_id' => $this->id,
            'likeable_id' => $model->id,
            'likeable_type' => get_class($model),
        ])->exists();
    }

    public function countLikes()
    {
        return $this->likes()->count();
    }
}
