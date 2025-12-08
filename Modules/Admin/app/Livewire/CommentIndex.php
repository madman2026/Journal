<?php

namespace Modules\Admin\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Interaction\Models\Comment;

class CommentIndex extends Component
{
    use WithPagination;

    public function accept($id)
    {
        Comment::findOrFail($id)->update(['status' => true]);
        $this->dispatch('toastMagic', status: 'success', message: 'نظر تایید شد');
    }

    public function delete($id)
    {
        Comment::findOrFail($id)->delete();
        $this->dispatch('toastMagic', status: 'success', message: 'نظر حذف شد');
    }

    public function acceptAll()
    {
        Comment::where('status', false)->update(['status' => true]);
        $this->dispatch('toastMagic', status: 'success', message: 'همه نظرات تایید شدند');
    }
    public function deleteAll()
    {
        Comment::where('status', false)->delete();
        $this->dispatch('toastMagic', status: 'success', message: 'همه نظرات حذف شدند');
    }

    public function render()
    {
        return view('admin::livewire.comment-index', [
            'comments' => Comment::where('status', false)
                ->latest()
                ->paginate(10),
        ]);
    }
}
