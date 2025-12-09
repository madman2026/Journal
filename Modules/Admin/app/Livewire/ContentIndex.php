<?php

namespace Modules\Admin\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Activity\Actions\DeleteActivityAction;
use Modules\Activity\Models\Activity;
use Modules\Core\Actions\DeleteRecommendAction;
use Modules\Core\Contracts\HasDownloadableContentComponent;
use Modules\Core\Models\Recommend;
use Modules\Magazine\Actions\DeleteMagazineAction;
use Modules\Magazine\Models\Magazine;
use Modules\Tip\Actions\DeleteTipAction;
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
            'key' => 'slug',
            'deleteAction' => DeleteActivityAction::class,
        ],
        'tips' => [
            'model' => Tip::class,
            'with' => ['user'],
            'withCount' => [],
            'pageName' => 'tips_page',
            'key' => 'slug',
            'deleteAction' => DeleteTipAction::class,
        ],
        'magazines' => [
            'model' => Magazine::class,
            'with' => ['user'],
            'withCount' => ['articles'],
            'pageName' => 'magazines_page',
            'key' => 'slug',
            'deleteAction' => DeleteMagazineAction::class,
        ],
        'recommends' => [
            'model' => Recommend::class,
            'with' => ['user'],
            'withCount' => [],
            'pageName' => 'recommends_page',
            'key' => 'slug',
            'deleteAction' => DeleteRecommendAction::class,
        ],
    ];

    /**
     * حذف محتوا بر اساس نوع و کلید
     */
    public function deleteContent(string $type, $identifier)
    {
        if (! isset($this->contentMap[$type])) {
            return $this->dispatch('toastMagic', status: 'error', title: 'خطا', message: 'نوع محتوا معتبر نیست.');
        }

        $config = $this->contentMap[$type];
        $model = $config['model'];
        $key = $config['key'] ?? 'slug';

        $content = $model::where($key, $identifier)->first();

        if (! $content) {
            return $this->dispatch('toastMagic', status: 'error', title: 'خطا', message: 'محتوا یافت نشد.');
        }

        try {
            app($config['deleteAction']::class)->handle($content);
            $this->dispatch('toastMagic',
                success: 'success',
                message: 'محتوا با موفقیت حذف شد.',
            );
        } catch (\Throwable $e) {
            report($e);

            $this->dispatch('toastMagic',
                status: 'error',
                title: 'خطا',
                message: 'خطا در حذف محتوا'
            );
        }
    }

    /**
     * بارگذاری محتوای مختلف با pagination
     */
    protected function loadContents(): array
    {
        $result = [];

        foreach ($this->contentMap as $key => $config) {
            $query = $config['model']::query();

            if (! empty($config['with'])) {
                $query->with($config['with']);
            }

            if (! empty($config['withCount'])) {
                $query->withCount($config['withCount']);
            }

            $result[$key] = $query
                ->latest()
                ->paginate(10, ['*'], $config['pageName']);
        }

        return $result;
    }

    public function render()
    {
        $contents = $this->loadContents();

        return view('admin::livewire.content-index', [
            'activities' => $contents['activities'],
            'tips' => $contents['tips'],
            'magazines' => $contents['magazines'],
            'recommends' => $contents['recommends'],
        ]);
    }

    /**
     * استخراج متن از فیلدهای محتوا
     */
    public function extractContent($item, array $fields = ['content', 'description', 'body']): string
    {
        foreach ($fields as $field) {
            if (! empty($item->$field)) {
                return strip_tags($item->$field);
            }
        }

        return '';
    }
}
