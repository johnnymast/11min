<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group([
    'prefix'     => '/',
    'middleware' => ['minify_html']
], function () {

    /**
     * Display pages
     */
    Route::get('/page/{pages_slug}', 'PagesController@show');

    /**
     * Display and handle the contact form
     */
    Route::get('/contact', 'ContactController@show')->name('contact');
    Route::post('/contact', 'ContactController@store')->name('contact_store');

    /**
     * Show the homepage and create the user account.
     */
    Route::get('/', 'HomeController@show')->name('home');
});

Route::group([
    'prefix'     => '/system',
    'middleware' => ['minify_html', 'is_valid_account']
], function () {

    /**
     * Increase the time for this account by 10 minutes
     */
    Route::get('/increase', 'SystemController@addTime');

    /**
     * Reset the time to the time now + 10 minutes
     */
    Route::get('/reset', 'SystemController@resetTime');

    /**
     * Get the messages arrived in the user's mailbox
     */
    Route::get('/messages', 'SystemController@messages');

    /**
     * Get the remaining time for this account.
     */
    Route::get('/time', 'SystemController@timeRemaining');

    /**
     * Retire this account. Refresh and create a new account.
     */
    Route::get('/retire', 'SystemController@retireAccount')->name('retire');

    /**
     * Display user email
     */
    Route::get('/email/{mailId}', 'SystemController@displayMail');
});

/**
 * CRUD pages
 */
Route::group(['middleware' => ['isAuthEnabled', 'isValidAdmin', 'minify_html']], function () {
    Route::resource('pages', 'PagesController', [
        'except' => ['show'],
    ]);
});

/**
 * Enable auth but only when granted
 * from the .env file.
 */
if (env('AUTH_ENABLED')) {
    Auth::routes();
}
