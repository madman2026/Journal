<?php

namespace Modules\Core\Contracts;

use Gate;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;

trait HasInteractableComponent
{
    public $has_liked = false;

    public function initializeHasLiked(): void
    {
        if (! $this->content) {
            return;
        }

        $userId = Auth::id();
        if (! $userId) {
            $this->has_liked = false;

            return;
        }

        $this->has_liked = $this->content->likes()
            ->where('user_id', $userId)
            ->exists();
    }

    public function toggleLike()
    {
        if (auth()->check()) {
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
                $this->has_liked = false;

                $this->dispatch('toastMagic',
                    status: 'success',
                    title: 'موفقیت',
                    message: 'لایک حذف شد'
                );
                $this->refreshStats();

                return;
            }

            $this->content->likes()->create([
                'user_id' => $userId,
                'ip_address' => $ip,
            ]);
            $this->has_liked = true;
            $this->refreshStats();
            $this->dispatch('toastMagic',
                status: 'success',
                title: 'موفقیت',
                message: 'لایک شد'
            );
        }else{
            $this->dispatch('toastMagic',
                status: 'error',
                title: 'خطا',
                message: 'برای این عملیات باید ابتدا ثبت نام کنید'
            );
        }

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

    #[Validate('required|')]
    public $commentBody;

    public function makeComment()
    {
        $this->validateOnly('commentBody', [
            'commentBody' => 'required|string|min:1|max:1000',
        ]);
        $this->content->comments()->create([
            'user_id' => Auth::id(),
            'body' => $this->commentBody,
            'ip_address' => request()->ip(),
        ]);
        $this->dispatch('toastMagic',
            status: 'success',
            title: 'موفقیت',
            message: 'نظر با موفقیت ایجاد شد. منتظر تائید باشید'
        );
    }
}
