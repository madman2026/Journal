<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">ویرایش نشریه</h1>

    <form wire:submit="update" enctype="multipart/form-data" class="space-y-6">
        {{-- عنوان --}}
        <x-core::form.text-input
            name="title"
            label="عنوان نشریه"
            placeholder="عنوان نشریه را وارد کنید"
            wire:model="title"
            required
            :rule="$rules['title']"
            :error="$errors->first('title')"
        />

        {{-- توضیحات --}}
        <x-core::form.textarea
            name="desc"
            label="توضیحات نشریه"
            placeholder="توضیحات نشریه را وارد کنید"
            wire:model="desc"
            rows="3"
            required
            :error="$errors->first('desc')"
        />

        {{-- تصویر نشریه --}}
        @if($magazine->image)
            <div class="flex items-center gap-4 mb-4">
                <img src="{{ asset($magazine->image) }}" alt="{{ $magazine->title }}" class="w-32 h-32 object-cover rounded">
                <span class="text-sm text-gray-600 dark:text-gray-400">عکس فعلی</span>
            </div>
        @endif

        <x-core::form.file-input 
            :required="false" 
            accept="image/*" 
            label="عکس جدید (اختیاری)" 
            name="image"  
        />

        @if($magazine->attachment)
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ asset($magazine->attachment) }}" target="_blank" class="text-blue-500 hover:underline">
                    فایل PDF فعلی
                </a>
            </div>
        @endif

        <x-core::form.file-input 
            :required="false" 
            label="فایل PDF جدید (اختیاری)" 
            name="attachment" 
            accept="application/pdf" 
        />

        {{-- دسته‌بندی‌ها --}}
        <x-core::form.select
            name="categories"
            label="دسته‌بندی‌ها"
            wire:model="categories"
            :options="$categoryOptions"
            multiple
            required
            :error="$errors->first('categories')"
        />

        {{-- مقالات --}}
        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">مقالات</h3>

            @foreach($articles as $index => $article)
                <div wire:key="article-{{ $index }}" class="border rounded-lg p-4 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-medium text-gray-800 dark:text-white">مقاله شماره {{ $index + 1 }}</h4>
                        @if($index > 0)
                            <x-core::form.button
                                type="button"
                                variant="danger"
                                wire:click="removeArticle({{ $index }})"
                            >
                                <x-heroicon-o-trash class="w-5 h-5" />
                                حذف
                            </x-core::form.button>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <x-core::form.text-input
                            name="articles.{{ $index }}.title" 
                            placeholder="عنوان مقاله" 
                            label="عنوان مقاله {{ $index + 1 }}"
                            wire:model="articles.{{ $index }}.title"
                        />
                        <x-core::form.text-input
                            name="articles.{{ $index }}.author" 
                            placeholder="نویسنده مقاله" 
                            label="نویسنده مقاله {{ $index + 1 }}"
                            wire:model="articles.{{ $index }}.author"
                        />
                    </div>

                    @if(isset($article['existing_attachment']) && $article['existing_attachment'])
                        <div class="mb-2">
                            <a href="{{ asset($article['existing_attachment']) }}" target="_blank" class="text-sm text-blue-500 hover:underline">
                                فایل فعلی مقاله
                            </a>
                        </div>
                    @endif

                    <x-core::form.file-input 
                        label='فایل مقاله جدید (اختیاری)' 
                        name="articles.{{ $index }}.attachment" 
                        accept=".pdf,.docx" 
                    />

                    <x-core::form.textarea 
                        label="چکیده مقاله" 
                        name="articles.{{ $index }}.abstract" 
                        placeholder="چکیده مقاله" 
                        wire:model="articles.{{ $index }}.abstract"
                    />

                    <x-core::form.textarea 
                        label='متن مقاله' 
                        name="articles.{{ $index }}.body" 
                        placeholder="متن مقاله" 
                        wire:model="articles.{{ $index }}.body"
                    />

                </div>
            @endforeach

            <button
                type="button"
                wire:click="addArticle"
                class="flex items-center gap-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
            >
                <x-heroicon-o-plus class="w-5 h-5" />
                افزودن مقاله جدید
            </button>
        </div>

        {{-- دکمه ثبت --}}
        <div class="flex gap-4 pt-6">
            <x-core::form.button
                type="submit"
                variant="primary"
                class="flex-1"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove wire:target="update">به‌روزرسانی نشریه</span>
                <span wire:loading wire:target="update" class="flex items-center gap-2">
                    <x-loader size="w-4 h-4" />
                    در حال به‌روزرسانی...
                </span>
            </x-core::form.button>

            <x-core::form.button
                type="button"
                variant="secondary"
                onclick="window.history.back()"
            >
                انصراف
            </x-core::form.button>
        </div>
    </form>

</div>
