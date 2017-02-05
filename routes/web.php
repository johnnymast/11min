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

    Route::get('/page/{pages_slug}', 'PagesController@show');


    /**
     * Pages
     */

    Route::get('/about', 'About@show')->name('about');
    Route::get('/', 'Web@index')->name('home');

    Route::get('/datasource', 'Mail@dataSource')->middleware('account.is_valid_account');
    Route::get('/remaining_time', 'Mail@getRemainingTime')->middleware('account.is_valid_account');
    Route::get('/add_time', 'Mail@addTime')->middleware('account.is_valid_account');
    Route::get('/reset', 'Mail@resetTime');
    Route::get('/read_email/{mailId}', 'Web@displayMail')->middleware('account.is_valid_account');
    Route::get('/send_email', 'Mail@sendEmail')->middleware('account.is_valid_account');
    Route::get('/retire', 'Web@retire')->name('retire'); //->middleware('account.is_valid_account');;

});

/**
 * Contact page
 */
Route::get('/contact', 'ContactController@show')->name('contact');
Route::post('/contact', 'ContactController@store')->name('contact_store');


Route::group(['middleware' => 'isAuthEnabled'], function()
{
    Route::resource('pages', 'PagesController', [
        'except' => ['show'],
    ]);
});

/**
 * Enable auth is granted
 */
if (env('AUTH_ENABLED')) {
    Auth::routes();
}
