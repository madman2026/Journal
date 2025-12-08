<?php

namespace Modules\Core\Contracts;

use Illuminate\Support\Facades\Auth;

trait HasInteractableComponent
{
    public $has_liked = false;
    public $commentBody;

    public function initializeHasLiked(): void
    {
        if (! $this->content) return;

        $userId = Auth::id();

        $this->has_liked = $this->content->likes()
            ->where('user_id', $userId)
            ->exists();
    }

    public function toggleLike()
    {
        if (! auth()->check()) {
            return $this->dispatch('toastMagic',
                status: 'error',
                title: 'خطا',
                message: 'برای لایک باید وارد شوید'
            );
        }

        $userId = Auth::id();
        $ip = request()->ip();

        $existingLike = $this->content->likes()
            ->where('user_id', $userId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();

            $this->has_liked = false;
            $this->refreshStats();

            return $this->dispatch('toastMagic',
                status: 'success',
                title: 'موفقیت',
                message: 'لایک حذف شد'
            );
        }

        $this->content->likes()->create([
            'user_id' => $userId,
            'ip_address' => $ip,
        ]);

        $this->has_liked = true;
        $this->refreshStats();

        return $this->dispatch('toastMagic',
            status: 'success',
            title: 'موفقیت',
            message: 'با موفقیت لایک شد'
        );
    }

    public function visitAction()
    {
        $ip = request()->ip();
        $userId = auth()->id();

        $exists = $this->content->views()
            ->where('ip_address', $ip)
            ->when($userId, fn($q) => $q->orWhere('user_id', $userId))
            ->exists();

        if (! $exists) {
            $this->content->views()->create([
                'ip_address' => $ip,
                'user_id' => $userId,
            ]);
        }
    }

    public function makeComment()
    {
        if (! auth()->check()) {
            return $this->dispatch('toastMagic',
                status: 'error',
                title: 'خطا',
                message: 'ابتدا وارد شوید'
            );
        }

        $this->validate([
            'commentBody' => 'required|string|min:1|max:1000',
        ]);

        $this->content->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->commentBody,
            'ip_address' => request()->ip(),
        ]);

        $this->commentBody = '';

        $this->content->refresh()->load([
            'comments' => fn ($q) => $q->where('status', true),
        ]);

        $this->refreshStats();

        return $this->dispatch('toastMagic',
            status: 'success',
            title: 'موفقیت',
            message: 'نظر ثبت شد. پس از تأیید نمایش داده می‌شود.'
        );
    }
}
