<?php

use Illuminate\Support\Facades\Route;

Route::as('magazine.')->prefix('magazine')->group(function () {
    Route::get('', \Modules\Magazine\Livewire\MagazineIndex::class)->name('index');
    Route::get('s/{Magazine}', \Modules\Magazine\Livewire\MagazineShow::class)->name('show');
    Route::get('create', \Modules\Magazine\Livewire\MagazineCreate::class)->middleware(['auth:Web' , 'role:super-admin|admin'])->name('create');
    Route::get('e/{Magazine}', \Modules\Magazine\Livewire\MagazineEdit::class)->middleware(['auth:Web' , 'role:super-admin|admin'])->name('edit');
});
Route::get('article/s/{Article}', \Modules\Magazine\Livewire\ArticleShow::class)->name('article.show');
