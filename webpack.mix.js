const mix = require('laravel-mix');
const glob = require('glob');
const path = require('path');
const ReplaceInFileWebpackPlugin = require('replace-in-file-webpack-plugin');
const rimraf = require('rimraf');


//  SCSS
(glob.sync('Modules/**/!(_)*.scss') || []).forEach(file => {
    file = file.replace(/[\\\/]+/g, '/');
    mix.sass(file, `public/css/${file.replace('Resources/assets/sass/', '').replace(/\.scss/, '.css')}`);
    // mix.sass(file, file.replace('Resources/assets/sass/', 'public/css/').replace(/\.scss$/, '.css'));
});

// JS
(glob.sync('Modules/**/*.js') || []).forEach(file => {
    mix.js(file, `public/js/${file.replace('Resources/assets/js/', '')}`);
});
