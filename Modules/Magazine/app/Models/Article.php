<?php

namespace Modules\Magazine\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\app\Contracts\HasSlug;
use Modules\Core\App\Contracts\Interactable;
use Modules\Core\Contracts\Likeable;
use Modules\Core\Models\Category;
use Modules\Interaction\Models\Comment;
use Modules\Interaction\Models\View;

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
        'url',
    ];

    public function magazine()
    {
        return $this->belongsTo(Magazine::class);
    }

    public function categories()
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
