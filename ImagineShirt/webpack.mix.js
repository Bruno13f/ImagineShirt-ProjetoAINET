// webpack.mix.js

let mix = require('laravel-mix');

mix.js('src/app.js', 'dist').setPublicPath('dist');

//mix.copyDirectory('resources/fonts','public/fonts');