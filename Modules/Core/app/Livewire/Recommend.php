<?php

namespace Modules\Core\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Core\Actions\MakeRecommendAction;

class Recommend extends Component
{
    use WithFileUploads;

    public $word;

    public $attachment;

    public $title;

    protected MakeRecommendAction $action;

    public function rules()
    {
        return [
            'word' => 'required|file|mimes:docx,doc',
            'attachment' => 'required|file|mimes:pdf',
            'title' => 'required|string',
        ];
    }

    public function boot(MakeRecommendAction $action)
    {
        $this->action = $action;
    }

    public function save()
    {
        $data = $this->validate();
        if ($this->word) {
            $data['word'] = $this->word->store('recommends/words', 'public');
        }
        if ($this->attachment) {
            $data['attachment'] = $this->attachment->store('recommends/attachment', 'public');
        }
        $result = $this->action->handle($data);

        if ($result->status) {
            $this->dispatch('toastMagic',
                status: 'success',
                title: 'ثبت شد',
                message: 'فرم با موفقیت ارسال شد'
            );

            return $this->redirectRoute('home');
        }
        $this->dispatch('toastMagic',
            status: 'success',
            title: 'ثبت شد',
            message: 'فرم با موفقیت ارسال شد'
        );

    }

    public function render()
    {
        return view('core::livewire.recommend');
    }
}
