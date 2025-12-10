<main class="p-6" x-data="{ openReply: null }">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">لیست فرم‌ها</h1>
    </div>

    <div class="overflow-x-auto rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
        <table class="w-full border-collapse text-sm">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                <tr>
                    <th class="border border-gray-300 dark:border-gray-700 p-3">نویسنده</th>
                    <th class="border border-gray-300 dark:border-gray-700 p-3">متن</th>
                    <th class="border border-gray-300 dark:border-gray-700 p-3">شماره تماس</th>
                    <th class="border border-gray-300 dark:border-gray-700 p-3">تاریخ</th>
                    <th class="border border-gray-300 dark:border-gray-700 p-3">اقدامات</th>
                </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-900">

                @foreach ($contacts as $contact)
                    <tr wire:key="contact-{{ $contact->id }}" class="hover:bg-gray-50 dark:hover:bg-gray-800 transition duration-150">

                        <td class="border border-gray-300 dark:border-gray-700 p-3">
                            {{ $contact->user?->username ?? 'ناشناس' }}
                        </td>

                        <td class="border border-gray-300 dark:border-gray-700 p-3">
                            {{ $contact->body }}
                        </td>

                        <td class="border border-gray-300 dark:border-gray-700 p-3">
                            {{ $contact->phone }}
                        </td>

                        <td class="border border-gray-300 dark:border-gray-700 p-3">
                            {{ $contact->created_at->diffForHumans() }}
                        </td>

                        <td class="border border-gray-300 dark:border-gray-700 p-3 space-x-2 text-center">

                            <!-- دکمه حذف -->
                            <button
                                wire:click="delete({{ $contact->id }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded-lg transition">
                                حذف
                            </button>
                        </td>
                    </tr>

                @endforeach

            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $contacts->links() }}
    </div>
</main>
