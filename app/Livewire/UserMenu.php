<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserMenu extends Component
{
    public bool $open = false;

    public $user;

    public $roles = [];

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->roles = $this->user?->getRoleNames()->toArray() ?? [];
    }

    public function toggleMenu(): void
    {
        $this->open = ! $this->open;
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }

    public function render(): View
    {
        return view('livewire.user-menu');
    }
}
