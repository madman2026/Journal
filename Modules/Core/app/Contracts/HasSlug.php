<?php

namespace Modules\Core\Contracts;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model): void {
            $model->generateSlugOnCreate();
        });

        static::updating(function ($model): void {
            $model->generateSlugOnUpdate();
        });
    }

    protected function generateSlugOnCreate(): void
    {
        if (empty($this->slug) && ! empty($this->title)) {
            $this->slug = $this->generateUniqueSlug($this->title);
        }
    }

    protected function generateSlugOnUpdate(): void
    {
        if ($this->isDirty('title') && ! empty($this->title)) {
            $this->slug = $this->generateUniqueSlug($this->title, $this->id);
        }
    }

    protected function generateUniqueSlug(string $value, $exceptId = null): string
    {
        $slug = Str::slug($value);
        $original = $slug;
        $count = 1;

        while (
            $this->newQuery()
                ->where('slug', $slug)
                ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
                ->exists()
        ) {
            $slug = "{$original}-{$count}";
            $count++;
        }

        return $slug;
    }
}
