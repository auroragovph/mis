const mix = require('laravel-mix');
const glob = require('glob');
const path = require('path');
const ReplaceInFileWebpackPlugin = require('replace-in-file-webpack-plugin');
const rimraf = require('rimraf');

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

// Default
mix.js('resources/js/app.js', 'public/js')
    .scripts('resources/js/config.js', 'public/js/config.js');


// GLOBAL SCSS
(glob.sync('resources/sass/**/!(_)*.scss') || []).forEach(file => {
    file = file.replace(/[\\\/]+/g, '/');
    mix.sass(file, file.replace('resources/sass/', 'public/css/').replace(/\.scss$/, '.css'));
});

// GLOBAL JAVASCRIPT 
(glob.sync('resources/js/pages/**/*.js') || []).forEach(file => {
    mix.js(file, `public/js/${file.replace('resources/js/', '')}`);
});

// Global jquery
// mix.autoload({
    // 'jquery': ['$', 'jQuery'],
    // Popper: ['popper.js', 'default'],
// });

// 3rd party plugins css/js
mix.sass('resources/plugins/plugins.scss', 'public/plugins/global/plugins.bundle.css').then(() => {
    // remove unused preprocessed fonts folder
    rimraf(path.resolve('public/fonts'), () => {});
    rimraf(path.resolve('public/images'), () => {});
})
    // .setResourceRoot('./')
    .options({processCssUrls: false})
    .js(['resources/plugins/plugins.js'], 'public/plugins/global/plugins.bundle.js');

// Metronic css/js
mix.sass('resources/metronic/sass/style.scss', 'public/css/style.bundle.css', {
    sassOptions: {includePaths: ['node_modules']},
})
    // .options({processCssUrls: false})
    .js('resources/js/scripts.js', 'public/js/scripts.bundle.js');

// Custom 3rd party plugins
(glob.sync('resources/plugins/custom/**/*.js') || []).forEach(file => {
    mix.js(file, `public/${file.replace('resources/', '').replace('.js', '.bundle.js')}`);
});
(glob.sync('resources/plugins/custom/**/*.scss') || []).forEach(file => {
    mix.sass(file, `public/${file.replace('resources/', '').replace('.scss', '.bundle.css')}`)
});

// Metronic css pages (single page use)
(glob.sync('resources/metronic/sass/pages/**/!(_)*.scss') || []).forEach(file => {
    file = file.replace(/[\\\/]+/g, '/');
    mix.sass(file, file.replace('resources/metronic/sass', 'public/css').replace(/\.scss$/, '.css'));
});

// // Metronic js pages (single page use)
// (glob.sync('resources/metronic/js/pages/**/*.js') || []).forEach(file => {
//     mix.js(file, `public/${file.replace('resources/metronic/', '')}`);
// });



// IMPORT MODULES

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


// Metronic media
mix.copyDirectory('resources/metronic/media', 'public/media');
mix.copyDirectory('resources/plugins/cdn', 'public/plugins/cdn');

// Metronic theme
// (glob.sync('resources/metronic/sass/themes/**/!(_)*.scss') || []).forEach(file => {
//     file = file.replace(/[\\\/]+/g, '/');
//     mix.sass(file, file.replace('resources/metronic/sass', 'public/css').replace(/\.scss$/, '.css'));
// });

mix.webpackConfig({
    plugins: [
        new ReplaceInFileWebpackPlugin([
            {
                // rewrite font paths
                dir: path.resolve('public/plugins/global'),
                test: /\.css$/,
                rules: [
                    {
                        // fontawesome
                        search: /url\(.*?webfonts\/(fa-)/ig,
                        replace: 'url\(./fonts/@fortawesome/$1'
                    },
                    {
                        // fontawesome-pro
                        search: /url\(.*?font\/(fa-)/ig,
                        replace: 'url\(./fonts/font-awesome-pro/$1'
                    },
                    {
                        // flaticon
                        search: /url\(.*?font\/(Flaticon\.)/ig,
                        replace: 'url\("./fonts/flaticon/$1',
                    },
                    {
                        // flaticon2
                        search: /url\(.*?font\/(Flaticon2\.)/ig,
                        replace: 'url\("./fonts/flaticon2/$1',
                    },
                    {
                        // keenthemes fonts
                        search: /url\(.*?(Ki\.)/ig,
                        replace: 'url\("./fonts/keenthemes-icons/$1'
                    },
                    {
                        // lineawesome fonts
                        search: /url\(.*?fonts\/(la-)/ig,
                        replace: 'url("./fonts/line-awesome/$1'
                    },
                ],
            },
        ]),
    ],
});

// Webpack.mix does not copy fonts, manually copy
(glob.sync('resources/metronic/plugins/**/*.+(woff|woff2|eot|ttf|svg)') || []).forEach(file => {
    var folder = file.match(/resources\/metronic\/plugins\/(.*?)\//)[1];
    mix.copy(file, `public/plugins/global/fonts/${folder}/${path.basename(file)}`);
});

(glob.sync('node_modules/+(@fortawesome|socicon|line-awesome)/**/*.+(woff|woff2|eot|ttf)') || []).forEach(file => {
    var folder = file.match(/node_modules\/(.*?)\//)[1];
    mix.copy(file, `public/plugins/global/fonts/${folder}/${path.basename(file)}`);
});
