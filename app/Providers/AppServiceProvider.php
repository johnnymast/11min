<?php

namespace App\Providers;

use App\Page;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use JM\MailReader\MailReader;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::share('pages', (new Page)->allActive());
        \View::share('slug', '');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       //App::bind('MailReader', function() {
       //    $reader = new MailReader();
       //    $reader->connect([
       //        'server'   => env('MAILREADER_HOST'),
       //        'username' => env('MAILREADER_USERNAME'),
       //        'password' => env('MAILREADER_PASSWORD'),
       //        'post'     => env('MAILREADER_PORT'),
       //    ]);
       //    return $reader;
       //});
    }
}
