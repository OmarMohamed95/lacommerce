let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css',{ implementation: require('node-sass') });

mix.js('resources/assets/js/App/search.js', 'public/js/App');
mix.js('resources/assets/js/App/cart.js', 'public/js/App');
mix.js('resources/assets/js/App/photoGallery.js', 'public/js/App');
mix.js('resources/assets/js/App/review.js', 'public/js/App');
mix.js('resources/assets/js/App/profile.js', 'public/js/App');
mix.js('resources/assets/js/App/wishlist.js', 'public/js/App');
mix.js('resources/assets/js/App/cartShared.js', 'public/js/App');
mix.js('resources/assets/js/App/addToCart.js', 'public/js/App');