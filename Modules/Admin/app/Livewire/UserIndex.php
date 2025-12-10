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

    public $roles = [];          // [id => name]
    public $selectedRoles = [];  // [userId => roleId]

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'selectedRoles.*' => 'nullable|integer|exists:roles,id',
    ];

    public function mount()
    {
        // نقش‌ها رو می‌گیریم به شکل [id => name]
        $this->roles = Role::where('name', '!=', 'super-admin')
            ->pluck('name', 'id')
            ->toArray();

        // پر کردن نقش‌های فعلی کاربرها
        $this->fillSelectedRoles();
    }

    public function updatedPage()
    {
        // هنگام تغییر صفحه نقش‌ها sync می‌شن
        $this->fillSelectedRoles();
    }

    private function fillSelectedRoles()
    {
        $users = User::where('username', '!=', 'admin')
            ->with('roles:id,name')
            ->paginate(10);

        foreach ($users as $user) {
            $this->selectedRoles[$user->id] = $user->roles->pluck('id')->first();
        }
    }

    public function changeRole($userId, $roleId)
    {
        try {
            $user = User::findOrFail($userId);

            $user->syncRoles([$roleId]);

            $this->selectedRoles[$userId] = $roleId;

            $roleName = $this->roles[$roleId] ?? '---';

            $this->toast('info', 'نقش تغییر کرد', "نقش {$user->username} به {$roleName} تغییر کرد.");
        } catch (\Exception $e) {
            Log::error("Error changing user role: " . $e->getMessage());
            $this->toast('error', 'خطا', 'در تغییر نقش مشکلی رخ داد.');
        }
    }

    private function toast($status, $title, $message)
    {
        $this->dispatch('toastMagic', status: $status, title: $title, message: $message);
    }

    public function render()
    {
        $users = User::where('username', '!=', 'admin')
            ->with('roles:id,name')
            ->paginate(10);

        return view('admin::livewire.user-index', compact('users'));
    }
}
