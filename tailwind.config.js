
module.exports = {
    mode: 'jit',
    purge: [
        'Modules/**/Resoures/**/*.tw.blade.php'
    ],

    theme: {
        extend: {},
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [],
};
