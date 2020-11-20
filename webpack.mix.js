const mix = require('laravel-mix');
require('laravel-mix-purgecss');

const MixGlob = require('laravel-mix-glob');

const mixGlob = new MixGlob({mix});

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


mixGlob.js('Modules/FileManagement/Resources/assets/js/**/*.js', 'public/js/filemanagement');
mixGlob.sass('Modules/FileManagement/Resources/assets/sass/**/*.scss', 'public/css/filemanagement');

mixGlob.js('Modules/FileTracking/Resources/assets/js/**/*.js', 'public/js/filetracking');
mixGlob.sass('Modules/FileTracking/Resources/assets/sass/**/*.scss', 'public/css/filetracking');

mixGlob.js('Modules/System/Resources/assets/js/**/*.js', 'public/js/system');

mix.js('resources/js/app.js', 'public/js/app.js')
    .sass('resources/sass/app.scss', 'public/css/style.css')
