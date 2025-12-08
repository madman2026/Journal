<?php

namespace Modules\Admin\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Activity\Actions\DeleteActivityAction;
use Modules\Core\App\Contracts\HasDownloadableContentComponent;
use Modules\Activity\Models\Activity;
use Modules\Core\Models\Recommend;
use Modules\Magazine\Models\Magazine;
use Modules\Tip\Models\Tip;

class ContentIndex extends Component
{
    use HasDownloadableContentComponent, WithPagination;

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

    public function deleteContent(string $type, $slug)
    {
        try {
            if (! isset($this->contentMap[$type])) {
                throw new \Exception('نوع محتوا معتبر نیست.');
            }

            $model = $this->contentMap[$type]['model'];
            $content = $model::whereSlug($slug)->first();

            if (! $content) {
                throw new \Exception('محتوا یافت نشد.');
            }

            app(DeleteActivityAction::class)->handle($content);

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
        $contents = [];

        foreach ($this->contentMap as $key => $config) {
            $query = $config['model']::query()
                ->when($config['with'], fn ($q, $r) => $q->with($r))
                ->when($config['withCount'], fn ($q, $r) => $q->withCount($r));

            $contents[$key] = $query
                ->orderByDesc('created_at')
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
        $fields = ['content', 'description', 'body'];

        foreach ($fields as $field) {
            if (! empty($item->$field)) {
                return strip_tags($item->$field);
            }
        }

        return '';
    }
}
