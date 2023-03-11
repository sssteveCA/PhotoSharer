import { js, sass } from 'laravel-mix';

js('resources/js/app.js','public/js')
    .js('resources/js/jquery.js','public/js')
    .ts('resources/ts/partials/menu.ts','public/js')
    .ts('resources/ts/login.ts','public/js')
    .ts('resources/ts/register.ts','public/js')

sass('resources/sass/app.scss','public/css')