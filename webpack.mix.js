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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .options({
      extractVueStyles: true, // Extract .vue component styling to file, rather than inline.
      globalVueStyles: path.resolve('resources/sass/_vue_global.scss'), // Variables file to be imported in every component.
   });

   if (mix.inProduction()) {
      mix.version();
  } else {
      mix.browserSync('saba-intl.test');
      mix.webpackConfig({
          devtool: 'inline-source-map'
      }); // https: //github.com/JeffreyWay/laravel-mix/issues/879#issuecomment-310749504
  }