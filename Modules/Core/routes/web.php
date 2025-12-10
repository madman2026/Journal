<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Livewire\Recommend;

Route::as('core.')->group(function () {
    Route::get('recommend', Recommend::class)->middleware('auth:Web')->name('recommend');
    Route::get('search', \Modules\Core\Livewire\Search::class)->name('search');
    Route::get('contact', \Modules\Core\Livewire\ContactCreate::class)->middleware('auth:Web')->name('contact');
});
