<?php

namespace Modules\Interaction\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Interaction\Database\Factories\LikeFactory;

class Like extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
        'ip_address'
    ];

    public function user()
    {
        return $this->morphTo();
    }

    public function likeable()
    {
        return $this->morphTo();
    }
}
