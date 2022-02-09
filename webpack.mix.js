const mix = require('laravel-mix');
const glob = require('glob');

//  SCSS
(glob.sync('modules/**/!(_)*.scss') || []).forEach(file => {
    file = file.replace(/[\\\/]+/g, '/');
    mix.sass(file, `public/css/${file.replace('resources/sass/', '').replace(/\.scss/, '.css')}`);
});

// JS
(glob.sync('modules/**/*.js') || []).forEach(file => {
    mix.js(file, `public/js/${file.replace('resources/js/', '')}`);
});

// SCSS ALL
(glob.sync('resources/sass/**/*.scss') || []).forEach(file => {
    file = file.replace(/[\\\/]+/g, '/');
    mix.sass(file, `public/css/${file.replace('resources/sass/', '').replace(/\.scss/, '.css')}`);
});

// JS ALL
(glob.sync('resources/js/**/*.js') || []).forEach(file => {
    file = file.replace(/[\\\/]+/g, '/');
    mix.js(file, `public/js/${file.replace('resources/js/', '')}`);
});


// copy media to public
mix.copyDirectory('resources/media', 'public/media')

let public_path = "public/libraries/"

// Libraries and Plugins
let plugins = {

    "node_modules/@tabler/core/dist/css/tabler.min.css": public_path + "tabler/tabler.min.css",
    "node_modules/@tabler/core/dist/css/tabler-vendors.min.css": public_path + "tabler/tabler-vendors.min.css",
    "node_modules/@tabler/core/dist/js/tabler.min.js": public_path + "tabler/tabler.min.js",

    // jquery
    "node_modules/jquery/dist/jquery.slim.min.js": public_path + "jquery/jquery.slim.min.js",
    "node_modules/jquery/dist/jquery.min.js": public_path + "jquery/jquery.min.js",

    // axios
    "node_modules/axios/dist/axios.min.js": public_path + "axios/axios.min.js",

    // form serialize
    "node_modules/form-serialize/index.js": public_path + "form-serialize/form-serialize.js",

    // sweetalert
    "node_modules/sweetalert2/dist/sweetalert2.all.min.js": public_path + "sweetalert2/sweetalert2.all.min.js",

    // tom-select
    "node_modules/tom-select/dist/css/tom-select.min.css": public_path + "tom-select/tom-select.min.css",
    "node_modules/tom-select/dist/css/tom-select.bootstrap5.min.css": public_path + "tom-select/tom-select.bootstrap5.min.css",
    "node_modules/tom-select/dist/js/tom-select.complete.min.js": public_path + "tom-select/tom-select.complete.min.js",

    // repeater
    "node_modules/jquery.repeater/jquery.repeater.min.js": public_path + "repeater/repeater.min.js",

}

for (plugin in plugins) {
    mix.copy(plugin, plugins[plugin]);
}




