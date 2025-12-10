<div class="p-6">

    {{-- Title --}}
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100 flex items-center gap-2">
        <x-heroicon-o-users class="w-6 h-6" />
        مدیریت کاربران
    </h1>

    {{-- Table --}}
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

                    {{-- User --}}
                    <td class="px-4 py-3 flex items-center gap-3">
                        <img src="{{ asset($user->image) ?? asset('images/default-avatar.png') }}"
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
                    <td class="px-4 py-3 w-48">
                        <x-core::form.select
                            name="selectedRoles.{{ $user->id }}"
                            wire:model="selectedRoles.{{ $user->id }}"
                            :options="$roles"
                            label="نقش کاربر"
                        />
                    </td>

                    {{-- Quick Apply --}}
                    <td class="px-4 py-3 text-center">
                        <button
                            wire:click="changeRole({{ $user->id }}, {{ $selectedRoles[$user->id] ?? 'null' }})"
                            class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition text-sm dark:bg-green-500 dark:hover:bg-green-600">
                            اعمال
                        </button>
                    </td>

                </tr>

            @empty
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
