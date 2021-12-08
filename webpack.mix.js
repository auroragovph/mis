const mix = require('laravel-mix');
const glob = require('glob');


//  SCSS
(glob.sync('modules/**/!(_)*.scss') || []).forEach(file => {
    file = file.replace(/[\\\/]+/g, '/');
    mix.sass(file, `public/css/${file.replace('Resources/assets/sass/', '').replace(/\.scss/, '.css')}`);
    // mix.sass(file, file.replace('Resources/assets/sass/', 'public/css/').replace(/\.scss$/, '.css'));
});

// JS
(glob.sync('modules/**/*.js') || []).forEach(file => {
    mix.js(file, `public/js/${file.replace('Resources/assets/js/', '')}`);
});


// TW
mix.postCss("resources/css/tw.css", "public/css", [
    require("tailwindcss"),
]);

