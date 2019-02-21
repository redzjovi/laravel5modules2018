const { mix } = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/Resources/assets/js/app.js', 'js/medium.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'css/medium.css');

if (mix.inProduction()) {
    mix.version();
}