let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
    .scripts([
	'public/js/app.js',
	'vendor/konekt/appshell/src/resources/assets/js/appshell.js'
    ], 'public/js/app.js')
    .sass('vendor/konekt/appshell/src/resources/assets/sass/appshell.sass', 'public/css');
