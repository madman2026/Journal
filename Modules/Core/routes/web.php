<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Livewire\Recommend;

Route::as('core.')->group(function () {
    Route::get('recommend', Recommend::class)->name('recommend');
    Route::get('search', \Modules\Core\Livewire\Search::class)->name('search');
    Route::get('contact-us', \Modules\Core\Livewire\ContactCreate::class)->name('contact');
    Route::get('contact', \Modules\Core\Livewire\ContactCreate::class)->name('contact.alias');
});
