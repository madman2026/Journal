<?php

namespace Modules\Activity\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Core\app\Contracts\HasSlug;
use Modules\Core\Contracts\Interactable;
use Modules\Core\Models\Category;
use Modules\User\Models\User;

// use Modules\Activity\Database\Factories\ActivityFactory;

class Activity extends Model
{
    use HasSlug , Interactable;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'image',
        'attachment',
        'level_id',
        'slug',
    ];

    public function getTypeWordAttribute()
    {
        return 'رویداد';
    }

    public function getRouteNameAttribute()
    {
        return 'activity.show';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
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
