<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PagesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::bind('pages_slug', function($slug = '') {
            return \App\Page::where('slug', $slug)->where('active', true)->first();
            return \App\Page::where('slug', $slug)->where('active', true)->firstOrFail();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //

    }
}