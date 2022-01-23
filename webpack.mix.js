const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */


// copy media to public
mix.copyDirectory('resources/media', 'public/media')



// Libraries and Plugins
mix.copy('node_modules/@tabler/core/dist/css/tabler.min.css', 'public/libraries/tabler/tabler.min.css')
.copy('node_modules/@tabler/core/dist/css/tabler-vendors.min.css', 'public/libraries/tabler/tabler-vendors.min.css')
.copy('node_modules/@tabler/core/dist/js/tabler.min.js', 'public/libraries/tabler/tabler.min.js');






