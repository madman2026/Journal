<?php

use Illuminate\Support\Facades\Route;

Route::prefix('user')->as('user.')->middleware('auth')->group(function () {
    Route::get('', \Modules\User\Livewire\Profile::class)->name('profile');
});
