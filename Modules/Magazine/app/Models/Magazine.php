<?php

namespace Modules\Magazine\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Core\app\Contracts\HasSlug;
use Modules\Core\Contracts\Interactable;
use Modules\Core\Models\Category;
use Modules\User\Models\User;

// use Modules\Magazine\Database\Factories\MagazineFactory;

class Magazine extends Model
{
    use HasSlug , Interactable;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'user_id',
        'attachment',
        'body',
    ];

    public function getRouteNameAttribute()
    {
        return 'magazine.show';
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset($this->image)
            : null;
    }

    public function getTypeWordAttribute()
    {
        return 'نشریه';
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
