<?php

namespace Modules\Magazine\Livewire;

use Livewire\Component;
use Modules\Core\App\Contracts\HasDownloadableContentComponent;
use Modules\Core\Contracts\HasInteractableComponent;
use Modules\Magazine\Models\Magazine;
use Modules\Magazine\Services\MagazineService;

class MagazineShow extends Component
{
    use HasDownloadableContentComponent , HasInteractableComponent;

    public ?Magazine $content = null;  // Use Magazine model type

    public array $categories = [];

    public array $relateds = [];

    protected MagazineService $service;

    public function boot(MagazineService $service): void
    {
        $this->service = $service;
    }

    public function mount(Magazine $Magazine): void
    {
        // Load the magazine with relationships and counts
        $this->content = $Magazine->loadCount([
            'comments' => fn ($q) => $q->where('status', true),
            'views',
            'likes',
        ])->load([
            'user',
            'articles',
            'comments' => fn ($q) => $q->where('status', true),
            'categories',
        ]);

        if (! $this->content) {
            $this->dispatch('toastMagic',
                status: 'error',
                title: 'خطا!',
                message: 'نشریه پیدا نشد!'
            );

            $this->redirectRoute('home');

            return;
        }

        // Map categories
        $this->categories = $this->content->categories->map(fn ($c) => [
            'id' => $c->id,
            'name' => $c->name,
        ])->toArray();

        // Fetch related magazines
        $categoryIds = $this->content->categories->pluck('id');

        $relatedQuery = Magazine::where('id', '!=', $Magazine->id);

        if ($categoryIds->isNotEmpty()) {
            $relatedQuery->whereHas('categories', fn ($q) => $q->whereIn('id', $categoryIds));
        }

        $this->relateds = $relatedQuery
            ->with(['user', 'categories'])
            ->withCount(['likes', 'views', 'comments'])
            ->limit(10)
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'title' => $r->title,
                'slug' => $r->slug,
                'image' => $r->image,
                'user' => [
                    'id' => $r->user->id,
                    'username' => $r->user->username,
                ],
                'likes_count' => $r->likes_count,
                'views_count' => $r->views_count,
                'comments_count' => $r->comments_count,
            ])->toArray();

        // Initialize likes and visit
        $this->initializeHasLiked();
        $this->visitAction();

        // Refresh stats using service
        $this->refreshStats();
    }

    public function refreshStats(): void
    {
        if (! $this->content) {
            return;
        }

        $updated = $this->service->get(Magazine::find($this->content->id));

        if ($updated->status) {
            $this->content->likes_count = $updated->data['magazine']['likes_count'];
            $this->content->views_count = $updated->data['magazine']['views_count'];
            $this->content->comments_count = $updated->data['magazine']['comments_count'];
        }
    }

    public function render()
    {
        return view('magazine::livewire.magazine-show');
    }
}
