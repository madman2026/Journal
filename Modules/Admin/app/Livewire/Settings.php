<?php

namespace Modules\Admin\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Modules\Activity\Models\Level;
use Modules\Core\Models\Category;
use Modules\Core\Models\FooterLink;
use Modules\Core\Models\Section;

class Settings extends Component
{
    use WithFileUploads;

    public $categories = [];
    public $levels = [];
    public $sections = [];
    public $links = [];

    public $category;
    public $level;
    public $linkName;
    public $link;

    public $sectionInputs = [];

    public function mount()
    {
        $this->categories = Category::get();
        $this->levels = Level::get();
        $this->sections = Section::get();

        $this->links = FooterLink::get();

        foreach ($this->sections as $section) {
            $this->sectionInputs[$section->name] = null;
        }
    }

    public function addCategory()
    {
        Category::create([
            'name' => $this->category
        ]);

        $this->category = '';
        $this->mount();
    }

    public function addlevel()
    {
        Level::create([
            'name' => $this->level
        ]);

        $this->level = '';
        $this->mount();
    }

    public function addLink()
    {
        $this->validate([
            'linkName' => 'required',
            'link' => 'required|url'
        ]);

        FooterLink::create([
            'name' => $this->linkName,
            'link' => $this->link
        ]);

        $this->linkName = '';
        $this->link = '';
        $this->mount();
    }

    public function deleteLink($id)
    {
        FooterLink::find('id', $id)->delete();
        $this->mount();
    }

    public function updateSections()
    {
        foreach ($this->sectionInputs as $key => $value) {
            if ($value) {
                Section::where('name', $key)->update([
                    'content' => $value
                ]);
            }
        }
        $this->dispatch('toastMagic',
            status: 'success',
            title: 'ورود موفق',
            message: 'تنظیمات با موفقیت ذخیره شد'
        );
    }

    public function render()
    {
        return view('admin::livewire.settings');
    }
}
