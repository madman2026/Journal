<div class="p-6">

    {{-- Title --}}
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100 flex items-center gap-2">
        <x-heroicon-o-users class="w-6 h-6" />
        مدیریت کاربران
    </h1>

    {{-- Save All Changes --}}
    <button
        wire:click="updateUsers"
        class="mb-4 px-5 py-2 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700 transition dark:bg-blue-500 dark:hover:bg-blue-600">
        ذخیره همه تغییرات
    </button>

    {{-- User Table --}}
    <div class="overflow-x-auto rounded-xl shadow-sm dark:shadow-gray-800">
        <table class="w-full text-sm text-left bg-white dark:bg-gray-800 dark:text-gray-200">
            <thead class="bg-gray-100 dark:bg-gray-700/60 text-gray-700 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-3">کاربر</th>
                    <th class="px-4 py-3">ایمیل</th>
                    <th class="px-4 py-3">نقش</th>
                    <th class="px-4 py-3 text-center">اعمال</th>
                </tr>
            </thead>

            <tbody>
            @forelse($users as $user)
                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                    {{-- User Info --}}
                    <td class="px-4 py-3 flex items-center gap-3">
                        <img src="{{ $user->avatar_url ?? '/images/default-avatar.png' }}"
                             class="w-10 h-10 rounded-full border dark:border-gray-700 object-cover">

                        <div>
                            <div class="font-medium">{{ $user->username }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                ID: {{ $user->id }}
                            </div>
                        </div>
                    </td>

                    {{-- Email --}}
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                        {{ $user->email ?? '—' }}
                    </td>

                    {{-- Role Selector --}}
                    <td class="px-4 py-3">
                        <select
                            wire:model.live="selectedRoles.{{ $user->id }}"
                            class="w-40 px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="">انتخاب نقش</option>

                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>

                    {{-- Quick Apply --}}
                    <td class="px-4 py-3 text-center">
                        <button
                            wire:click="changeRole({{ $user->id }}, '{{ $selectedRoles[$user->id] }}')"
                            class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition text-sm dark:bg-green-500 dark:hover:bg-green-600">
                            اعمال
                        </button>
                    </td>
                </tr>

            @empty
                {{-- Empty State --}}
                <tr>
                    <td colspan="4" class="py-6 text-center text-gray-500 dark:text-gray-400">
                        هیچ کاربری یافت نشد.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
