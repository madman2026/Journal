<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Models\FooterLink;
use Modules\Core\Models\Section;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view): void {
            $sections = Section::query()
                ->whereIn('name', ['titleFooter', 'aboutUs', 'contactUs'])
                ->pluck('content', 'name');

            $view->with('footerData', [
                'titleFooter' => $sections->get('titleFooter'),
                'aboutUs' => $sections->get('aboutUs'),
                'contactUs' => $sections->get('contactUs'),
                'links' => FooterLink::query()->get(['id', 'name', 'link']),
            ]);
        });
    }
}
