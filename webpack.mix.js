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
mix
    .autoload({
        'popper.js/dist/umd/popper.js': ['Popper']
    })
	.js('resources/js/app.js', 'public/js')

	.js('vendor/konekt/appshell/src/resources/assets/js/appshell.standalone.js', 'public/js/appshell.js')
    .sass('vendor/konekt/appshell/src/resources/assets/sass/appshell.sass', 'public/css');
