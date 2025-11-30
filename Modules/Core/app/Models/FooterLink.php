<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

// use Modules\Core\Database\Factories\FooterLinkFactory;

class FooterLink extends Model
{
    protected $fillable = [
        'name',
        'link',
    ];
}
