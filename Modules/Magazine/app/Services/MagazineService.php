<?php

namespace Modules\Magazine\Services;

use Modules\Magazine\Models\Magazine;

class MagazineService
{
    public function create(array $data)
    {
        // === Create Magazine ===
        $magazine = Magazine::create([
            'title' => $data['title'],
            'desc' => $data['desc'],
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

    }
}
