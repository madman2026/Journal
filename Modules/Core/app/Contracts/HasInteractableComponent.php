<?php

namespace Modules\Core\Contracts;

use Illuminate\Support\Facades\Auth;

trait HasInteractableComponent
{
    public function toggleLikeAction()
    {
        $userId = Auth::id();
        $ip = request()->ip();

        $existingLike = $this->content->likes()
            ->where(function ($q) use ($userId, $ip) {
                $q->when($userId, fn ($x) => $x->where('user_id', $userId))
                    ->when(! $userId, fn ($x) => $x->where('ip_address', $ip));
            })
            ->first();

        if ($existingLike) {
            $existingLike->delete();

            return false;
        }

        $this->content->likes()->create([
            'user_id' => $userId,
            'ip_address' => $ip,
        ]);

        return true;
    }

    public function visitAction()
    {
        $ip = request()->ip();
        $userId = auth()->id();

        $exists = $this->content->views()
            ->where(function ($q) use ($ip, $userId) {
                $q->where('ip_address', $ip);

                if ($userId) {
                    $q->orWhere('user_id', $userId);
                }
            })
            ->exists();

        if (! $exists) {
            $this->content->views()->create([
                'ip_address' => $ip,
                'user_id' => $userId,
            ]);
        }
    }

    public function makeCommentAction(string $text)
    {
        return $this->content->comments()->create([
            'user_id' => Auth::id(),
            'text' => $text,
            'ip_address' => request()->ip(),
        ]);
    }
}
