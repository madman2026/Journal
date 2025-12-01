<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Livewire\LandingPage;

Route::get('/', LandingPage::class)->name('home');
