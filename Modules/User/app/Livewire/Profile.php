<?php

namespace Modules\User\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\User\Services\UserService;

class Profile extends Component
{
    use WithFileUploads;

    public $user;

    public $username;

    public $name;

    public $number;

    public $email;

    public $image;

    public $delete = false;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'username' => 'required|string|min:3|max:255|unique:users,username,'.$this->user['id'],
            'number' => 'required|numeric',
            'email' => 'required|email|max:255|unique:users,email,'.$this->user['id'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function mount()
    {
        $this->user = Auth::user()->toArray();
        $this->name = $this->user['name'] ?? '';
        $this->username = $this->user['username'] ?? '';
        $this->number = $this->user['number'] ?? '';
        $this->email = $this->user['email'] ?? '';
    }

    public function updateUser()
    {
        $this->validate();

        $user = auth('web')->user();
        $user->name = $this->name;
        $user->username = $this->username;
        $user->number = $this->number;
        $user->email = $this->email;

        if ($this->image) {
            $user->image = $this->image->store('profiles', 'public');
        }

        $user->save();

        $this->dispatch('toastMagic',
            status: 'success',
            title: 'موفقیت',
            message: 'اطلاعات با موفقیت به روز شد.'
        );
    }

    public function render()
    {
        return view('user::livewire.profile');
    }
}
