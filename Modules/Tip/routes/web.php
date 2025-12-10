<?php

use Illuminate\Support\Facades\Route;
use Modules\Tip\Livewire\TipCreate;
use Modules\Tip\Livewire\TipEdit;
use Modules\Tip\Livewire\TipIndex;
use Modules\Tip\Livewire\TipShow;

Route::as('tip.')->prefix('tip')->group(function () {
    Route::get('', TipIndex::class)->name('index');
    Route::get('s/{Tip}', TipShow::class)->name('show');
    Route::get('create', TipCreate::class)->middleware(['auth:Web' , 'role:super-admin'])->name('create');
    Route::get('e/{Tip}', TipEdit::class)->middleware(['auth:Web' , 'role:super-admin'])->name('edit');
});
