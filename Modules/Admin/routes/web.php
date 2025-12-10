<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:web')->as('admin.')->prefix('admin')->group(function () {
    Route::get('', \Modules\Admin\Livewire\Settings::class)->middleware('role:super-admin')->name('settings');
    Route::get('users', \Modules\Admin\Livewire\UserIndex::class)->middleware('role:super-admin')->name('users');
    Route::get('contents', \Modules\Admin\Livewire\ContentIndex::class)->middleware('role:super-admin')->name('contents');
    Route::get('contacts', \Modules\Admin\Livewire\ContactIndex::class)->middleware('role:super-admin|admin')->name('contacts');
    Route::get('comments', \Modules\Admin\Livewire\CommentIndex::class)->middleware('role:super-admin|admin')->name('comments');
});
