<?php

namespace Modules\Admin\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Activity\Models\Activity;
use Modules\Core\App\Contracts\HasDownloadableContentComponent;
use Modules\Core\Models\Recommend;
use Modules\Magazine\Models\Magazine;
use Modules\Tip\Models\Tip;

class ContentIndex extends Component
{
    use HasDownloadableContentComponent , WithPagination;

    // همه‌ی مدل‌ها + کانفیگ‌ها در یکجا
    protected array $contentMap = [
        'activities' => [
            'model' => Activity::class,
            'with' => ['user'],
            'withCount' => [],
            'pageName' => 'activities_page',
        ],
        'tips' => [
            'model' => Tip::class,
            'with' => ['user'],
            'withCount' => [],
            'pageName' => 'tips_page',
        ],
        'magazines' => [
            'model' => Magazine::class,
            'with' => ['user'],
            'withCount' => ['articles'],
            'pageName' => 'magazines_page',
        ],
        'recommends' => [
            'model' => Recommend::class,
            'with' => ['user'],
            'withCount' => [],
            'pageName' => 'recommends_page',
        ],
    ];

    // حذف محتوا
    public function deleteContent(string $type, $slug)
    {
        try {
            if (! isset($this->contentMap[$type])) {
                throw new \Exception('نوع محتوا معتبر نیست.');
            }
            $model = $this->contentMap[$type]['model'];
            $content = $model::whereSlug($slug)->first();

            $content->delete();
            $this->dispatch('toastMagic',
                success: 'success',
                message: 'محتوا با موفقیت حذف شد.',
            );

        } catch (\Exception $e) {
            report($e);
            $this->dispatch('toastMagic',
                success: 'error',
                message: 'خطا در حذف محتوا'
            );
        }
    }

    public function render()
    {
        // تمام دیتاها رو دینامیک لود می‌کنیم
        $contents = [];

        foreach ($this->contentMap as $key => $config) {
            $query = $config['model']::query();

            if (! empty($config['with'])) {
                $query->with($config['with']);
            }

            if (! empty($config['withCount'])) {
                $query->withCount($config['withCount']);
            }

            $contents[$key] = $query
                ->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], $config['pageName']);
        }

        return view('admin::livewire.content-index', [
            'activities' => $contents['activities'],
            'tips' => $contents['tips'],
            'magazines' => $contents['magazines'],
            'recommends' => $contents['recommends'],
        ]);
    }

    public function extractContent($item)
    {
        return strip_tags(
            $item->content
            ?? $item->description
            ?? $item->body
            ?? ''
        );
    }
}
