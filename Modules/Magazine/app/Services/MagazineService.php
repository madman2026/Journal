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
        return $this->execute(function () use ($magazine, $data) {
            // Update magazine fields
            $magazine->update([
                'title' => $data['title'] ?? $magazine->title,
                'body' => $data['desc'] ?? $magazine->body,
                'image' => $data['image'] ?? $magazine->image,
                'attachment' => $data['attachment'] ?? $magazine->attachment,
            ]);

            // Update categories
            if (isset($data['categories'])) {
                $magazine->categories()->sync($data['categories']);
            }

            // Update articles if provided
            if (isset($data['articles'])) {
                // Delete existing articles
                $magazine->articles()->delete();

                // Create new articles
                foreach ($data['articles'] as $article) {
                    $magazine->articles()->create([
                        'title' => $article['title'],
                        'author' => $article['author'],
                        'attachment' => $article['attachment'] ?? null,
                        'abstract' => $article['abstract'],
                        'body' => $article['body'],
                    ]);
                }
            }

            return $magazine->fresh();
        });
    }

    public function delete(Magazine $magazine)
    {
        return $this->execute(function () use ($magazine) {
            // Delete associated files
            if ($magazine->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($magazine->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($magazine->image);
            }

            if ($magazine->attachment && \Illuminate\Support\Facades\Storage::disk('public')->exists($magazine->attachment)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($magazine->attachment);
            }

            // Delete article files
            foreach ($magazine->articles as $article) {
                if ($article->attachment && \Illuminate\Support\Facades\Storage::disk('public')->exists($article->attachment)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($article->attachment);
                }
            }

            return $magazine->delete();
        });
    }

    public function get(Magazine $magazine)
    {
        return $this->execute(function () use ($magazine) {

            $magazine->loadCount([
                'comments' => fn ($q) => $q->where('status', true),
                'views',
                'likes',
            ])->load([
                'user',
                'articles',
                'comments' => fn ($q) => $q->where('status', true),
            ]);

            $categories = $magazine->categories()->get()->map(fn ($c) => [
                'id' => $c->id,
                'name' => $c->name,
            ])->toArray();

            $categoryIds = $magazine->categories()->pluck('id');

            $relatedsQuery = $categoryIds->isNotEmpty()
                ? Magazine::whereHas('categories', fn ($q) => $q->whereIn('id', $categoryIds))
                    ->where('id', '!=', $magazine->id)
                : Magazine::where('id', '!=', $magazine->id);

            $relateds = $relatedsQuery
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

            return [
                'categories' => $categories,
                'magazine' => $magazine,
                'relateds' => $relateds,
            ];
        });
    }
}
