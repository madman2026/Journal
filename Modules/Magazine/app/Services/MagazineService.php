<?php

namespace Modules\Magazine\Services;

use Modules\Core\app\Contracts\BaseService;
use Modules\Magazine\Models\Magazine;

class MagazineService extends BaseService
{
    public function create(array $data)
    {
        return $this->execute(function () use ($data) {
            // === Create Magazine ===
            $magazine = Magazine::create([
                'title' => $data['title'],
                'body' => $data['desc'],
                'user_id' => auth()->user()->id,
                'image' => $data['image'],
                'attachment' => $data['attachment'],
            ]);

            // === Attach Categories ===
            if (! empty($data['categories'])) {
                $magazine->categories()->sync($data['categories']);
            }

            // === Create Articles ===
            foreach ($data['articles'] as $article) {
                $magazine->articles()->create([
                    'title' => $article['title'],
                    'author' => $article['author'],
                    'attachment' => $article['attachment'],
                    'abstract' => $article['abstract'],
                    'body' => $article['body'],
                ]);
            }

            return $magazine;
        });
    }

    public function update(Magazine $magazine, array $data)
    {
        return $this->execute(function () use ($magazine,$data) {

        });
    }
    public function delete(Magazine $magazine)
    {
        return $this->execute(fn() => $magazine->delete());
    }

    public function get(Magazine $magazine)
    {
        return $this->execute(function () use ($magazine) {
            $magazine->loadCount(['comments', 'views', 'likes'])
                ->load([
                    'user',
                    'articles',
                    'comments' => fn ($q) => $q->where('status', 1),
                ]);

            $categoryIds = $magazine->categories()->pluck('id');

            $relateds = $categoryIds->isNotEmpty()
                ? Magazine::whereHas('categories', fn ($q) => $q->whereIn('id', $categoryIds))
                    ->where('id', '!=', $magazine->id)
                    ->with('user')
                    ->limit(10)
                    ->get()
                : Magazine::with('user')->limit(10)->get();

            $categories = $magazine->categories()->get();
            return compact('categories' , 'magazine' , 'relateds');
        });

    }
}
