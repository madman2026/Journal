<?php

namespace Modules\Magazine\Livewire;

use Livewire\Component;
use Modules\Core\App\Contracts\HasDownloadableContentComponent;
use Modules\Core\Contracts\HasInteractableComponent;
use Modules\Magazine\Models\Article;

class ArticleShow extends Component
{
    use HasInteractableComponent , HasDownloadableContentComponent;

    public $content;
    public $relateds;

    public function mount(Article $Article)
    {
        $this->content = $Article
            ->load([
                'comments' => fn ($q) => $q->where('status', true),
            ])
            ->loadCount([
                'comments' => fn ($q) => $q->where('status', true),
                'likes',
                'views']);
        $this->relateds = Article::whereHas('categories', function ($q) {
                $q->whereIn('categories.id', $this->content->categories->pluck('id'));
            })
            ->where('id', '!=', $this->content->id)
            ->limit(10)
            ->get();
        $this->initializeHasLiked(); // از Trait
        $this->visitAction();        // از Trait
    }

    public function refreshStats()
    {
        $this->content->loadCount([
            'comments' => fn ($q) => $q->where('status', true),
            'likes',
            'views',
        ]);
    }

    public function render()
    {
        return view('magazine::livewire.article-show');
    }
}
