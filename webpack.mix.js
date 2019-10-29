const mix = require('laravel-mix');

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
/*.js('resources/js/app.js', 'public/js')*/

mix.sass('resources/sass/app.sass', 'public/css')
    .js('resources/js/prices.js', 'public/js')
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/statistics/own-best-prices/index.js', 'public/js/statistics/own-best-prices.js')
    .js('resources/js/statistics/competitors-best-prices/index.js', 'public/js/statistics/competitors-best-prices.js')
    .js('resources/js/statistics/detailed-product-price/index.js', 'public/js/statistics/detailed-product-price.js')
    .js('resources/js/products/create/index.js', 'public/js/products/create/bulk-upload-fix.js')
    .js('resources/js/products/update/index.js', 'public/js/products/update/bulk-price-update-fix.js')
    .version()
