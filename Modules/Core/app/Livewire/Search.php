<?php

namespace Modules\Core\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Activity\Models\Activity;
use Modules\Magazine\Models\Article;
use Modules\Magazine\Models\Magazine;
use Modules\Tip\Models\Tip;

class Search extends Component
{
    use WithPagination;

    public string $search = '';

    public string $type = 'All';

    public int $page = 1;

    public bool $isSearching = false;

    public array $types = [
        'All',
        'Magazine',
        'Activity',
        'Tip',
        'Article',
    ];

    protected array $modelMap = [
        '1' => Magazine::class,
        '2' => Activity::class,
        '3' => Tip::class,
        '4' => Article::class,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => 'All'],
        'page' => ['except' => 1],
    ];

    public function updated($field)
    {
        if (in_array($field, ['search', 'type'])) {
            $this->resetPage();
        }
    }

    public function searchNow()
    {
        $this->isSearching = true;

        $this->validate([
            'search' => 'nullable|string|min:2|max:100',
            'type' => 'required|string|in:'.implode(',', array_keys($this->types)),
        ]);

        $this->resetPage();
        $this->isSearching = false;
    }

    public function getResultsProperty()
    {
        $perPage = 10;
        $search = trim($this->search);

        try {
            // Case: All models
            if ($this->type === 1) {
                $collections = collect($this->modelMap)->map(function ($model) use ($search, $perPage) {
                    return $model::query()
                        ->when($search !== '', fn ($q) => $q->where('title', 'like', "%{$search}%"))
                        ->latest()
                        ->take($perPage * 3)
                        ->get();
                });

                $merged = $collections->flatten()->sortByDesc('created_at')->values();

                return new LengthAwarePaginator(
                    $merged->forPage($this->page, $perPage),
                    $merged->count(),
                    $perPage,
                    $this->page,
                    ['path' => request()->url(), 'query' => request()->query()]
                );
            }

            // Case: Specific model
            if (array_key_exists($this->type, $this->modelMap)) {
                $model = $this->modelMap[$this->type];

                return $model::query()
                    ->when($search !== '', fn ($q) => $q->where('title', 'like', "%{$search}%"))
                    ->latest()
                    ->paginate($perPage, ['*'], 'page', $this->page);
            }
        } catch (\Exception $e) {
            Log::error('Search failed', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        // Fallback
        return Magazine::latest()->paginate($perPage);
    }

    public function render()
    {
        return view('core::livewire.search', [
            'results' => $this->results,
        ]);
    }
}
