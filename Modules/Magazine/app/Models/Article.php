<?php

namespace Modules\Magazine\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Core\app\Contracts\HasSlug;
use Modules\Core\Contracts\Interactable;
use Modules\Core\Models\Category;

class Article extends Model
{
    use HasSlug , Interactable;

    protected $fillable = [
        'title',
        'body',
        'author',
        'abstract',
        'slug',
        'magazine_id',
        'attachment',
    ];

    public function getRouteNameAttribute()
    {
        return 'article.show';
    }

    public function magazine(): BelongsTo
    {
        return $this->belongsTo(Magazine::class);
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
