<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrap(4);

        View::composer('*', function ($view) {
            static $navCategories = null;
            if ($navCategories === null) {
                try {
                    $navCategories = Category::where('is_active', true)->orderBy('name')->get();
                } catch (\Exception $e) {
                    $navCategories = collect();
                }
            }
            $view->with('navCategories', $navCategories);
        });

        Event::listen(Login::class, function (Login $event) {
            $event->user->timestamps = false;
            $event->user->update(['last_login_at' => now()]);
            $event->user->timestamps = true;
        });
    }
}
