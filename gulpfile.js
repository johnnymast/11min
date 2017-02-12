const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix
        .sass('app.scss')
        .sass('font-awesome/font-awesome.scss', 'resources/assets/css/font-awesome.css')
        .webpack('app.js', 'all.js')
        .scripts([
            'clipboard.min.js',
            'general.js',
            'bulma.js'
        ]).styles([
            'base.css',
            'bulma.css',
            'custom.css',
            'font-awesome.css',
        ]);
});
