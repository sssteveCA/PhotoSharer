const mix = require('laravel-mix');

mix.js('resources/js/app.js','public/js')
    .js('resources/js/jquery.js','public/js')
    .ts('resources/ts/partials/menu.ts','public/js')
    .ts('resources/ts/login.ts','public/js')
    .ts('resources/ts/register.ts','public/js')
    .sass('resources/scss/app.scss','public/css')