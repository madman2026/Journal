<?php

use Illuminate\Support\Facades\Route;

Route::as('activity.')->prefix('activity')->group(function () {
    Route::get('/', \Modules\Activity\Livewire\ActivityIndex::class)->name('index');
    Route::get('s/{Activity}', \Modules\Activity\Livewire\ActivityShow::class)->name('show');
    Route::get('create', \Modules\Activity\Livewire\ActivityCreate::class)->middleware(['auth:web' , 'role:super-admin'])->name('create');
    Route::get('e/{Activity}', \Modules\Activity\Livewire\ActivityEdit::class)->middleware(['auth:web' , 'role:super-admin'])->name('edit');
});
