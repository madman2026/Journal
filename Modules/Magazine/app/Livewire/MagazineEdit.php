<?php

namespace Modules\Magazine\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Core\Models\Category;
use Modules\Magazine\Models\Magazine;
use Modules\Magazine\Services\MagazineService;

class MagazineEdit extends Component
{
    use WithFileUploads;

    public Magazine $magazine;

    public $title = '';

    public $desc = '';

    public $image;

    public $attachment;

    public $categories = [];

    public $articles = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'desc' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        'attachment' => 'nullable|file|mimes:pdf,docx|max:10240',
        'categories' => 'required|array|min:1',
        'categories.*' => 'exists:categories,id',
        'articles' => 'required|array|min:1',
        'articles.*.title' => 'required|string|max:255',
        'articles.*.author' => 'required|string|max:255',
        'articles.*.attachment' => 'nullable|file|mimes:pdf,docx|max:10240',
        'articles.*.abstract' => 'required|string|min:50',
        'articles.*.body' => 'required|string|min:100',
    ];

    protected MagazineService $service;

    public function boot(MagazineService $service)
    {
        $this->service = $service;
    }

    public function mount(Magazine $Magazine)
    {
        $this->magazine = $Magazine;
        $this->title = $Magazine->title;
        $this->desc = $Magazine->body;
        $this->categories = $Magazine->categories()->pluck('id')->toArray();
        $this->articles = $Magazine->articles->map(function ($article) {
            return [
                'id' => $article->id,
                'title' => $article->title,
                'author' => $article->author,
                'attachment' => null,
                'abstract' => $article->abstract,
                'body' => $article->body,
                'existing_attachment' => $article->attachment,
            ];
        })->toArray();

        if (empty($this->articles)) {
            $this->articles = [
                ['title' => '', 'author' => '', 'attachment' => null, 'abstract' => '', 'body' => ''],
            ];
        }
    }

    public function addArticle()
    {
        $this->articles[] = ['title' => '', 'author' => '', 'attachment' => null, 'abstract' => '', 'body' => ''];
    }

    public function removeArticle($index)
    {
        if (count($this->articles) > 1) {
            unset($this->articles[$index]);
            $this->articles = array_values($this->articles);
        }
    }

    public function update()
    {
        $data = $this->validate();

        if ($this->image) {
            $data['image'] = $this->image->store('magazines/images', 'public');
        }

        if ($this->attachment) {
            $data['attachment'] = $this->attachment->store('magazines/attachments', 'public');
        }

        foreach ($data['articles'] as $index => $article) {
            if (isset($article['attachment']) && $article['attachment']) {
                $data['articles'][$index]['attachment'] =
                    $article['attachment']->store('magazines/articles', 'public');
            } elseif (isset($this->articles[$index]['existing_attachment'])) {
                $data['articles'][$index]['attachment'] = $this->articles[$index]['existing_attachment'];
            }
        }

        $result = $this->service->update($this->magazine, $data);

        if ($result->status) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: 'موفقیت',
                message: 'نشریه با موفقیت به‌روزرسانی شد.'
            );

            return $this->redirectRoute('magazine.show', ['Magazine' => $this->magazine->slug]);
        }

        $this->dispatch('toastMagic',
            status: 'error',
            title: 'خطا',
            message: $result->message
        );
    }

    public function render()
    {
        $categoryOptions = Category::all()->pluck('name', 'id')->toArray();

        return view('magazine::livewire.magazine-edit', [
            'categoryOptions' => $categoryOptions,
            'rules' => $this->rules,
        ]);
    }
}
