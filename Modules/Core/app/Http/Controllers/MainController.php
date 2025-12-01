<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Core\Livewire\ContactCreate;
use Modules\Core\Livewire\LandingPage;

class MainController extends Controller
{
    /**
     * Display the landing page.
     */
    public function landing()
    {
        return LandingPage::class;
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        return ContactCreate::class;
    }
}

