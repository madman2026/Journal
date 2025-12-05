<?php

namespace Modules\Tip\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\app\Contracts\HasSlug;
use Modules\Core\Contracts\Interactable;
use Modules\Core\Models\Category;
use Modules\User\Models\User;

class Tip extends Model
{
    use HasSlug , Interactable;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'image',
        'slug',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
