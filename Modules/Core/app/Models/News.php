<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Models\Scope;
use Modules\Core\app\Contracts\HasSlug;
use Modules\Core\Contracts\Likeable;
use Modules\Core\Models\Category;
use Modules\Interaction\Models\Comment;
use Modules\Interaction\Models\View;
use Modules\User\Models\User;

class News extends Model
{
    use HasSlug, Likeable;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'image',
        'pdf',
        'scope_id',
        'slug',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    public function likers()
    {
        return $this->morphMany(\Modules\Interaction\Models\Like::class, 'likeable');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
}

