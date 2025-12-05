<?php

namespace Modules\Admin\Livewire;

use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
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
        $this->loadAll();
    }

    private function loadAll()
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
        $this->validateOnly('category', [
            'category' => 'required|string|min:2|max:40',
        ]);

        Category::create(['name' => $this->category]);

        $this->category = '';
        $this->loadAll();
    }

    public function delCategory($id)
    {
        Category::where('id', $id)->delete();
        $this->loadAll();
    }

    public function addLevel()
    {
        $this->validateOnly('level', [
            'level' => 'required|string|min:1|max:40',
        ]);

        Level::create(['name' => $this->level]);

        $this->level = '';
        $this->loadAll();
    }

    public function delLevel($id)
    {
        Level::where('id', $id)->delete();
        $this->loadAll();
    }

    public function addLink()
    {
        $this->validate([
            'linkName' => 'required|string|max:100',
            'link' => 'required|url',
        ]);

        FooterLink::create([
            'name' => $this->linkName,
            'link' => $this->link,
        ]);

        $this->linkName = '';
        $this->link = '';

        $this->loadAll();
    }

    public function deleteLink($id)
    {
        FooterLink::where('id', $id)->delete();
        $this->loadAll();
    }

    public function updateSections()
    {
        foreach ($this->sectionInputs as $key => $value) {

            if (empty($value)) {
                continue;
            }

            $section = Section::where('name', $key)->first();

            // اگر فایل است
            if ($value instanceof TemporaryUploadedFile) {
                $path = $value->store('uploads/sections', 'public');
                $section->update(['content' => $path]);
            }
            // اگر متن است
            else {
                $section->update(['content' => $value]);
            }
        }

        $this->dispatch('toastMagic',
            status: 'success',
            title: 'عملیات موفق',
            message: 'تنظیمات با موفقیت ذخیره شد'
        );
    }

    public function render()
    {
        return view('admin::livewire.settings');
    }
}
