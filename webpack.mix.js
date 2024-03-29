const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/core.js', 'public/js')
    .js('resources/js/users-list.js', 'public/js')
    .js('resources/js/apartment-view.js', 'public/js')
    .js('resources/js/user-view.js', 'public/js')
    .js('resources/js/rates-list.js', 'public/js')
    .js('resources/js/user-edit.js', 'public/js')
    .js('resources/js/calendar.js', 'public/js')
    .js('resources/js/calendar-events.js', 'public/js')
    .js('resources/js/maintenance-list.js', 'public/js')
    .js('resources/js/vendors-list.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();