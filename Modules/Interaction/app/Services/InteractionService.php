<?php

namespace Modules\Interaction\Services;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\app\Contracts\BaseService;

class InteractionService extends BaseService
{
    public function makeComment(Model $model, array $comment)
    {
        return $this->execute(function () use ($model , $comment){
            $model->comments()->create([
                'user_id' => auth()->id(),
                'body' => $comment['body'],
        ]);
        });
    }

    public function visit(Model $model)
    {
        return $this->execute(function () use ($model){
            $exists = $model->views()
                ->where('user_id', auth()->id())
                ->where('ip_address', request()->ip())
                ->exists();

            if (! $exists) {
                $model->views()->create([
                    'user_id' => auth()->id(),
                    'ip_address' => request()->ip(),
                ]);
            }
        });
    }

    public function toggleLike(Model $model)
    {
        return $this->execute(function () use ($model){

            $like = $model->likes()
                ->where('user_id', auth()->id())
                ->where('ip_address', request()->ip())
                ->first();

            if ($like) {
                $like->delete();
                return false;
            }

            $model->likes()->create([
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
            ]);

            return true;
        });
    }
}
