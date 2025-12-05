<?php

namespace Modules\Core\Livewire;

use Livewire\Component;
use Modules\Core\Actions\MakeRecommendAction;

class Recommend extends Component
{
    public $word;

    public $pdf;

    public $title;

    protected MakeRecommendAction $action;

    public function boot(MakeRecommendAction $action)
    {
        $this->action = $action;
    }

    public function save()
    {
        $result = $this->action->handle($this->validate());

        if ($result) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: 'ثبت شد',
                message: 'فرم با موفقیت ارسال شد'
            );
            $this->redirectRoute('home');
        }
    }

    public function render()
    {
        return view('core::livewire.recommend');
    }
}
