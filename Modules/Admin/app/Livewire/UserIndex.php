<?php

namespace Modules\Admin\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\User\Models\User;
use Spatie\Permission\Models\Role;

class UserIndex extends Component
{
    use WithPagination;

    public $roles = [];

    public $selectedRoles = [];

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'selectedRoles.*' => 'nullable|string|exists:roles,name',
    ];

    public function mount()
    {
        // Load roles except super-admin
        $this->roles = Role::where('name', '!=', 'super-admin')
            ->select('id', 'name')
            ->get();

        // Preload roles for all users with one query
        User::where('username', '!=', 'admin')
            ->with('roles')
            ->get()
            ->each(function ($user) {
                $this->selectedRoles[$user->id] = $user->roles->pluck('name')->first();
            });
    }

    public function updateUsers()
    {
        $validated = $this->validate();

        try {
            foreach ($validated['selectedRoles'] as $userId => $roleName) {
                if (! $roleName) {
                    continue;
                }

                $user = User::find($userId);

                if ($user) {
                    $user->syncRoles([$roleName]);
                }
            }

            $this->toast('success', 'تغییرات اعمال شد', 'وضعیت و نقش کاربران به‌روزرسانی شد.');
        } catch (\Exception $e) {
            Log::error('Error updating users: '.$e->getMessage());

            $this->toast('error', 'خطا!', 'عملیات انجام نشد. دوباره تلاش کن.');
        }
    }

    public function changeRole($userId, $roleName)
    {
        try {
            $user = User::findOrFail($userId);
            $user->syncRoles([$roleName]);

            $this->selectedRoles[$userId] = $roleName;

            $this->toast('info', 'نقش کاربر تغییر کرد', "نقش {$user->username} به «{$roleName}» تغییر یافت.");
        } catch (\Exception $e) {
            Log::error('Error changing user role: '.$e->getMessage());

            $this->toast('error', 'خطا', 'در تغییر نقش مشکلی رخ داد.');
        }
    }

    private function toast($status, $title, $message)
    {
        $this->dispatch('toastMagic', status: $status, title: $title, message: $message);
    }

    public function render()
    {
        return view('admin::livewire.user-index', [
            'users' => User::where('username', '!=', 'admin')->paginate(10),
        ]);
    }
}
