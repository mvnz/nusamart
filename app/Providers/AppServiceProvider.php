<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
        // Use Bootstrap 4 pagination view (without icons)
        Paginator::useBootstrap(4);

        // Share categories with all views (for navbar + home + products page)
        View::composer('*', function ($view) {
            static $navCategories = null;
            if ($navCategories === null) {
                try {
                    $navCategories = Category::orderBy('name')->get();
                } catch (\Exception $e) {
                    $navCategories = collect();
                }
            }
            $view->with('navCategories', $navCategories);
        });
    }
}
