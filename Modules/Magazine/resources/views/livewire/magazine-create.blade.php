<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">ایجاد نشریه جدید</h1>

    <form wire:submit="save" enctype="multipart/form-data" class="space-y-6">
        {{-- عنوان --}}
        <x-core::form.text-input
            name="title"
            label="عنوان نشریه"
            placeholder="عنوان نشریه را وارد کنید"
            required
            :rule="$rules['title']"
            :error="$errors->first('title')"
        />

        {{-- توضیحات --}}
        <x-core::form.textarea
            name="desc"
            label="توضیحات نشریه"
            placeholder="توضیحات نشریه را وارد کنید"
            rows="3"
            required
            :error="$errors->first('desc')"
        />

        {{-- تصویر نشریه --}}
        <x-core::form.file-input :required="true" accept="image/*" :value="old('image')" label="عکس" name="image"  />

        <x-core::form.file-input :required="true" :value="old('attachment')" label="فایل PDF" name="attachment" accept="application/pdf" />


        {{-- دسته‌بندی‌ها --}}
        <x-core::form.select
            name="categories"
            label="دسته‌بندی‌ها"
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
                            name="articles.{{ $index }}.title" placeholder="عنوان مقاله" label="عنوان مقاله {{ $index + 1 }}"
                            />
                        <x-core::form.text-input
                        name="articles.{{ $index }}.author" placeholder="نویسنده مقاله" label="نویسنده مقاله {{ $index + 1 }}"
                            />
                    </div>

                    <x-core::form.file-input label='فایل مقاله' name="articles.{{ $index }}.attachment" accept=".pdf,.docx" />

                    <x-core::form.textarea label="چکیده مقاله" name="articles.{{ $index }}.abstract" placeholder="چکیده مقاله" />

                    <x-core::form.textarea label='متن مقاله' name="articles.{{ $index }}.body" placeholder="متن مقاله" />

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
                <span wire:loading.remove wire:target="save">ثبت نشریه</span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <x-loader size="w-4 h-4" />
                    در حال ثبت...
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
