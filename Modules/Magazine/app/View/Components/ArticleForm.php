<?php

namespace Modules\Magazine\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class ArticleForm extends Component
{
    public function render(): View|string
    {
        return view('magazine::components.articleform');
    }
}
