const mix = require('laravel-mix');
// require('es6-promise').polyfill()

// mix.options({
//     legacyNodePolyfills: false
// });

// module.exports = {
//     resolve: {
//         // fallback: {
//         //   "path": require.resolve("path-browserify"),
//         //   "crypto": require.resolve("crypto-browserify"),
//         //   "https": require.resolve("https-browserify"),
//         //   "http": require.resolve("stream-http"),
//         //   "vm": require.resolve("vm-browserify"),
//         //   "os": require.resolve("os-browserify/browser"),
//         // }
//         fallback: {
//             "path": false,
//             "crypto": false,
//             "https": false,
//             "http": false,
//             "vm": false,
//             "os": false,
//             "fs": false,
//             "tls": false,
//             "net": false,
//             "zlib": false,
//             "stream": false,
//           }
//       },
// }
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
    .vue()
    .postCss("resources/css/app.css", "public/css", [
        require("tailwindcss"),
        require('autoprefixer')
    ])