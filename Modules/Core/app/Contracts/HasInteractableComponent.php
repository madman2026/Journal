<?php

namespace Modules\Core\Contracts;

use Illuminate\Support\Facades\Auth;

trait HasInteractableComponent
{
    public $has_liked = false;
    public $commentBody;

    /**
     * Initialize like state for the current content.
     */
    public function initializeHasLiked(): void
    {
        if (!isset($this->content)) return;

        $userId = Auth::id();
        $this->has_liked = $userId && $this->content->likes()->where('user_id', $userId)->exists();
    }

    /**
     * Toggle like for the current content.
     */
    public function toggleLike()
    {
        if (! auth()->check()) {
            return $this->dispatch('toastMagic',
                status: 'error',
                title: 'خطا',
                message: 'برای لایک باید وارد شوید'
            );
        }

        if (!isset($this->content)) {
            return $this->dispatch('toastMagic',
                status: 'error',
                title: 'خطا',
                message: 'محتوا یافت نشد'
            );
        }

        $userId = Auth::id();
        $ip = request()->ip();

        $existingLike = $this->content->likes()->where('user_id', $userId)->first();

        if ($existingLike) {
            $existingLike->delete();
            $this->has_liked = false;
            $this->refreshStats();
            $this->loadComments();
            return $this->dispatch('toastMagic', status: 'success', title: 'موفقیت', message: 'لایک حذف شد');
        }

        // ایجاد لایک جدید
        $this->content->likes()->create([
            'user_id' => $userId,
            'ip_address' => $ip,
        ]);

        $this->has_liked = true;
        $this->refreshStats();
        $this->loadComments();
        return $this->dispatch('toastMagic', status: 'success', title: 'موفقیت', message: 'با موفقیت لایک شد');
    }

    /**
     * Track a visit to the content.
     */
    public function visitAction()
    {
        if (!isset($this->content)) return;

        $ip = request()->ip();
        $userId = auth()->id();

        $exists = $this->content->views()
            ->where(function($q) use ($ip, $userId) {
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

    /**
     * Create a comment for the content.
     */
    public function makeComment()
    {
        if (! auth()->check()) {
            return $this->dispatch('toastMagic',
                status: 'error',
                title: 'خطا',
                message: 'ابتدا وارد شوید'
            );
        }

        if (!isset($this->content)) {
            return $this->dispatch('toastMagic',
                status: 'error',
                title: 'خطا',
                message: 'محتوا یافت نشد'
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
        $this->refreshStats();
        $this->loadComments();
        return $this->dispatch('toastMagic',
            status: 'success',
            title: 'موفقیت',
            message: 'نظر ثبت شد. پس از تأیید نمایش داده می‌شود.'
        );
    }

    /**
     * Load only approved comments and set as relation.
     */
    public function loadComments()
    {
        if (isset($this->content)) {
            $this->content->setRelation(
                'comments',
                $this->content->comments()->where('status', true)->get()
            );
        }
    }

    /**
     * Refresh counts for likes, comments, views.
     */
    public function refreshStats()
    {
        if (!isset($this->content)) return;

        $this->content->loadCount([
            'likes',
            'views',
            'comments' => fn($q) => $q->where('status', true),
        ]);
    }
}
