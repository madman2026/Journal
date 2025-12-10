<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Activity\Models\Activity;
use Modules\Magazine\Models\Article;
use Modules\Magazine\Models\Magazine;
use Modules\Tip\Models\Tip;

// use Modules\Core\Database\Factories\CategoryFactory;

class Category extends Model
{
    protected $fillable = ['name'];

    public function articles(): MorphToMany
    {
        return $this->morphedByMany(Article::class, 'categorizable');
    }

    public function tips(): MorphToMany
    {
        return $this->morphedByMany(Tip::class, 'categorizable');
    }

    public function activities(): MorphToMany
    {
        return $this->morphedByMany(Activity::class, 'categorizable');
    }

    public function magazines(): MorphToMany
    {
        return $this->morphedByMany(Magazine::class, 'categorizable');
    }
}
