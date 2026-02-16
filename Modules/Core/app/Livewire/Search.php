<?php

namespace Modules\Core\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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

    public string $type = '0';

    public int $page = 1;

    public bool $isSearching = false;

    public array $types = [
        '0' => '???',
        '1' => '??????',
        '2' => '????????',
        '3' => '???? ??',
        '4' => '??????',
    ];

    protected array $modelMap = [
        '1' => Magazine::class,
        '2' => Activity::class,
        '3' => Tip::class,
        '4' => Article::class,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => '0'],
        'page' => ['except' => 1],
    ];

    public function updated(string $field): void
    {
        if (in_array($field, ['search', 'type'], true)) {
            $this->resetPage();
        }
    }

    public function searchNow(): void
    {
        $this->isSearching = true;

        $this->validate([
            'search' => 'nullable|string|min:2|max:100',
            'type' => 'required|string|in:'.implode(',', array_keys($this->types)),
        ]);

        $this->resetPage();
        $this->isSearching = false;
    }

    public function getResultsProperty(): LengthAwarePaginator
    {
        $perPage = 10;
        $search = trim($this->search);

        try {
            if ($this->type === '0') {
                return $this->buildAllResults($search, $perPage);
            }

            if (array_key_exists($this->type, $this->modelMap)) {
                $model = $this->modelMap[$this->type];

                return $this->buildQuery($model, $search)
                    ->latest()
                    ->paginate($perPage, ['*'], 'page', $this->page);
            }
        } catch (\Throwable $e) {
            Log::error('Search failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return Magazine::query()->latest()->paginate($perPage, ['*'], 'page', $this->page);
    }

    public function render(): View
    {
        return view('core::livewire.search', [
            'results' => $this->results,
        ]);
    }

    private function buildQuery(string $model, string $search)
    {
        return $model::query()
            ->with('categories')
            ->when($search !== '', fn ($q) => $q->where('title', 'like', "%{$search}%"));
    }

    private function buildAllResults(string $search, int $perPage): LengthAwarePaginator
    {
        /** @var Collection<int, Collection> $collections */
        $collections = collect($this->modelMap)->map(function (string $model) use ($search, $perPage) {
            return $this->buildQuery($model, $search)
                ->latest()
                ->take($perPage * 3)
                ->get();
        });

        $merged = $collections
            ->flatten(1)
            ->sortByDesc('created_at')
            ->values();

        return new LengthAwarePaginator(
            $merged->forPage($this->page, $perPage)->values(),
            $merged->count(),
            $perPage,
            $this->page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
