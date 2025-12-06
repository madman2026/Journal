<?php

namespace Modules\Magazine\Livewire;

use Livewire\Component;
use Modules\Magazine\Models\Magazine;

class MagazineIndex extends Component
{
    public function render()
    {
        return view('magazine::livewire.magazine-index' , [
            'magazines' => Magazine::orderByDesc('created_at')->with('user')->withCount(['comments' , 'likes' , 'views'])->paginate(10)
        ]);
    }
}
